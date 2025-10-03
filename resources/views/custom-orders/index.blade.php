@extends('layouts.app')

@section('title', 'Custom Orders')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Custom Orders</h1>
            <p class="text-gray-600 mt-1">Manage customer special requests</p>
        </div>
        <div class="flex items-center space-x-2 text-sm">
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full">{{ $orders->total() }} Total</span>
            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full">
                {{ $orders->where('status', 'pending')->count() }} Pending
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Customer</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Product</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Quantity</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">City</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Payment</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Date</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm text-gray-600">#{{ $order->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->customer_name }} {{ $order->customer_surname }}</p>
                            <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $order->product_name }}</p>
                        @if($order->product_url)
                            <a href="{{ $order->product_url }}" target="_blank" class="text-xs text-blue-600 hover:underline">
                                <i class="fas fa-link"></i> View Product
                            </a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-900">{{ $order->quantity }}</span>
                        <span class="text-sm text-gray-500">pcs</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-700">{{ $order->delivery_city }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="text-gray-900">{{ $order->payment_method }}</p>
                            <p class="text-xs text-gray-500">{{ $order->payment_currency }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-orange-100 text-orange-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'processing' => 'bg-purple-100 text-purple-700',
                                'shipped' => 'bg-cyan-100 text-cyan-700',
                                'delivered' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-700">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('custom-orders.show', $order->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-eye mr-2"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No custom orders yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection