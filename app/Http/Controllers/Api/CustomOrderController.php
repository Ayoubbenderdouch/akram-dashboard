<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomOrderController extends Controller
{
    public function index()
    {
        $orders = CustomOrder::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|image|max:5120',
            'product_url' => 'nullable|url',
            'destination_country' => 'required|string',
            'delivery_city' => 'required|string',
            'delivery_address' => 'required|string',
            'shipping_method' => 'required|in:DDP,Normal',
            'payment_method' => 'required|in:CCP,Baridimob,Cash,Bank Transfer,Binance,PayPal,EU Bank,Office',
            'payment_currency' => 'required|in:DZD,USD,EUR',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('product_image');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $path = $image->store('custom_orders', 'public');
            $data['product_image'] = $path;
        }

        $customOrder = CustomOrder::create($data);
        $customOrder->refresh();

        return response()->json([
            'message' => 'Custom order created successfully',
            'order' => $customOrder
        ], 201);
    }

    public function show($id)
    {
        $order = CustomOrder::where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($order);
    }
}
