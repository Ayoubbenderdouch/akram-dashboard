@extends('layouts.app')

@section('title', 'Statistics & Analytics')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📊 Statistics & Analytics</h1>
    <p class="text-gray-600 mt-2">Comprehensive insights into your business performance</p>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue Card -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-green-100 text-sm">Total Revenue</p>
                <h3 class="text-3xl font-bold mt-2">{{ number_format($totalRevenue, 0) }} DZD</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-white bg-opacity-20 rounded px-2 py-1">
                {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
            </span>
            <span class="ml-2 text-green-100">vs last month</span>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-blue-100 text-sm">Total Orders</p>
                <h3 class="text-3xl font-bold mt-2">{{ number_format($totalOrders) }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-white bg-opacity-20 rounded px-2 py-1">
                {{ $ordersGrowth >= 0 ? '+' : '' }}{{ number_format($ordersGrowth, 1) }}%
            </span>
            <span class="ml-2 text-blue-100">growth rate</span>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-purple-100 text-sm">Total Users</p>
                <h3 class="text-3xl font-bold mt-2">{{ number_format($totalUsers) }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-white bg-opacity-20 rounded px-2 py-1">
                {{ $usersGrowth >= 0 ? '+' : '' }}{{ number_format($usersGrowth, 1) }}%
            </span>
            <span class="ml-2 text-purple-100">new signups</span>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-orange-100 text-sm">Total Products</p>
                <h3 class="text-3xl font-bold mt-2">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center text-sm">
            <span class="bg-white bg-opacity-20 rounded px-2 py-1">{{ $outOfStockProducts }} out of stock</span>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Order Status Distribution -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">📈 Order Status Distribution</h3>
        <div class="space-y-4">
            @foreach(['pending' => 'yellow', 'paid' => 'blue', 'shipped' => 'green'] as $status => $color)
                @php
                    $count = $ordersByStatus[$status] ?? 0;
                    $percentage = $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0;
                @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700 capitalize">{{ $status }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-{{ $color }}-500 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">🏆 Top Selling Products</h3>
        <div class="space-y-3">
            @forelse($topProducts as $index => $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center text-white font-bold">
                            #{{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->orders_count }} orders</p>
                        </div>
                    </div>
                    <span class="text-lg font-bold text-green-600">{{ number_format($product->price, 0) }} DZD</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No sales data available</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Top Customers & Low Stock -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Customers -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">👥 Top Customers</h3>
        <div class="space-y-3">
            @forelse($topCustomers as $index => $customer)
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $customer->name }} {{ $customer->surname }}</p>
                            <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-purple-600">{{ number_format($customer->orders_sum_total_price ?? 0, 0) }} DZD</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No customer data available</p>
            @endforelse
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">⚠️ Low Stock Alerts</h3>
        <div class="space-y-3">
            @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                    <div>
                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">Min quantity: {{ $product->min_quantity }}</p>
                    </div>
                    <span class="px-3 py-1 bg-red-500 text-white text-sm font-bold rounded-full">
                        {{ $product->stock }} left
                    </span>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="text-6xl mb-2">✅</div>
                    <p class="text-gray-500">All products well stocked!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">🕐 Recent Activity</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $order->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->product->name }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-green-600">{{ number_format($order->total_price, 0) }} DZD</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-medium
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status === 'shipped' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No recent orders</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
