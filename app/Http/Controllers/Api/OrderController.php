<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:10',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validated['quantity'] > $product->stock) {
            return response()->json([
                'message' => 'Insufficient stock available',
                'available_stock' => $product->stock,
            ], 422);
        }

        $totalPrice = $product->price * $validated['quantity'];

        $order = DB::transaction(function () use ($request, $product, $validated, $totalPrice) {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'status' => 'pending',
            ]);

            $product->decrement('stock', $validated['quantity']);

            return $order;
        });

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => [
                'id' => $order->id,
                'product_name' => $product->name,
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'address' => $order->address,
                'phone_number' => $order->phone_number,
                'status' => $order->status,
            ],
        ], 201);
    }

    public function index(Request $request)
    {
        $orders = Order::with('product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'product_name' => $order->product->name,
                    'quantity' => $order->quantity,
                    'total_price' => $order->total_price,
                    'address' => $order->address,
                    'phone_number' => $order->phone_number,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                ];
            });

        return response()->json($orders);
    }

    public function total(Request $request)
    {
        $total = Order::where('user_id', $request->user()->id)
            ->sum('total_price');

        return response()->json([
            'total_spent' => $total,
        ]);
    }
}
