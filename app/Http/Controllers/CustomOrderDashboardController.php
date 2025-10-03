<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use Illuminate\Http\Request;

class CustomOrderDashboardController extends Controller
{
    public function index()
    {
        $orders = CustomOrder::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('custom-orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = CustomOrder::with('user')->findOrFail($id);
        return view('custom-orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'estimated_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string'
        ]);

        $order = CustomOrder::findOrFail($id);
        $order->update($request->only(['status', 'estimated_price', 'admin_notes']));

        return redirect()->route('custom-orders.show', $id)
            ->with('success', 'Order updated successfully');
    }
}
