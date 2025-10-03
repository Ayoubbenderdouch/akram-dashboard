@extends('layouts.app')

@section('title', 'Custom Order #' . $order->id)

@section('content')
<div class="p-8">
    <div class="mb-6">
        <a href="{{ route('custom-orders.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <i class="fas fa-arrow-left mr-2"></i> Back to Custom Orders
        </a>
    </div>

    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Custom Order #{{ $order->id }}</h1>
            <p class="text-gray-600 mt-1">Created on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>
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
        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box text-indigo-600 mr-3"></i> Product Details
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Product Name</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->product_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Quantity</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->quantity }} pieces</p>
                    </div>

                    @if($order->product_description)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Description</label>
                        <p class="text-gray-700 mt-1">{{ $order->product_description }}</p>
                    </div>
                    @endif

                    @if($order->product_url)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Product URL</label>
                        <a href="{{ $order->product_url }}" target="_blank" class="text-blue-600 hover:underline block mt-1">
                            <i class="fas fa-external-link-alt mr-1"></i> {{ $order->product_url }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-indigo-600 mr-3"></i> Customer Information
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Name</label>
                        <p class="text-gray-900 font-medium">{{ $order->customer_name }} {{ $order->customer_surname }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-900">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Phone</label>
                        <p class="text-gray-900">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">User ID</label>
                        <p class="text-gray-900">#{{ $order->user_id }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-truck text-indigo-600 mr-3"></i> Delivery Information
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Destination Country</label>
                        <p class="text-gray-900 font-medium">{{ $order->destination_country }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">City</label>
                        <p class="text-gray-900">{{ $order->delivery_city }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Address</label>
                        <p class="text-gray-700">{{ $order->delivery_address }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipping Method</label>
                        <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                            {{ $order->shipping_method }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-credit-card text-indigo-600 mr-3"></i> Payment Information
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Payment Method</label>
                        <p class="text-gray-900 font-medium">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Currency</label>
                        <p class="text-gray-900 font-medium">{{ $order->payment_currency }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Update Order</h2>
                <form action="{{ route('custom-orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Price</label>
                        <input type="number" step="0.01" name="estimated_price" value="{{ $order->estimated_price }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Enter estimated price">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea name="admin_notes" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  placeholder="Internal notes...">{{ $order->admin_notes }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition">
                        <i class="fas fa-save mr-2"></i> Update Order
                    </button>
                </form>
            </div>

            @if($order->estimated_price)
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border-2 border-green-200">
                <h3 class="text-lg font-bold text-green-800 mb-2">Estimated Price</h3>
                <p class="text-3xl font-bold text-green-700">{{ number_format($order->estimated_price, 2) }} {{ $order->payment_currency }}</p>
            </div>
            @endif

            @if($order->admin_notes)
            <div class="bg-yellow-50 rounded-xl shadow-lg p-6 border-2 border-yellow-200">
                <h3 class="text-lg font-bold text-yellow-800 mb-2">Admin Notes</h3>
                <p class="text-gray-700">{{ $order->admin_notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection