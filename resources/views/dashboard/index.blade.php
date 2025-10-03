@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Welcome back! Here\'s what\'s happening with your business.')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card-hover bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">+12%</span>
        </div>
        <h3 class="text-blue-100 text-sm font-semibold uppercase tracking-wide mb-2">Total Users</h3>
        <p class="text-4xl font-bold mb-1">{{ $userCount }}</p>
        <p class="text-blue-100 text-xs">Registered customers</p>
    </div>

    <div class="card-hover bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">Active</span>
        </div>
        <h3 class="text-emerald-100 text-sm font-semibold uppercase tracking-wide mb-2">Total Products</h3>
        <p class="text-4xl font-bold mb-1">{{ $productCount }}</p>
        <p class="text-emerald-100 text-xs">Available in catalog</p>
    </div>

    <div class="card-hover bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">Today</span>
        </div>
        <h3 class="text-orange-100 text-sm font-semibold uppercase tracking-wide mb-2">Total Orders</h3>
        <p class="text-4xl font-bold mb-1">{{ $orderCount }}</p>
        <p class="text-orange-100 text-xs">Orders received</p>
    </div>

    <div class="card-hover bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">DZD</span>
        </div>
        <h3 class="text-purple-100 text-sm font-semibold uppercase tracking-wide mb-2">Total Revenue</h3>
        <p class="text-4xl font-bold mb-1">{{ number_format($totalRevenue, 0) }}</p>
        <p class="text-purple-100 text-xs">Earnings this month</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-clock text-indigo-600 mr-3"></i>
                Recent Orders
            </h2>
            <p class="text-gray-500 text-sm mt-1">Latest transactions from your customers</p>
        </div>
        <a href="{{ route('orders.index') }}" class="flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-semibold bg-indigo-50 px-4 py-2 rounded-lg hover:bg-indigo-100 transition-all">
            View All <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
            </div>
            <p class="text-gray-500 font-medium">No orders yet</p>
            <p class="text-gray-400 text-sm mt-1">Your recent orders will appear here</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-indigo-600">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    {{ substr($order->user->name, 0, 1) }}{{ substr($order->user->surname, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $order->user->name }} {{ $order->user->surname }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $order->product->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700 font-medium">{{ $order->quantity }} <span class="text-gray-400">pcs</span></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900">{{ number_format($order->total_price, 2) }} <span class="text-gray-500 text-xs">DZD</span></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->status === 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-700">
                                    <i class="fas fa-clock mr-1"></i> Pending
                                </span>
                            @elseif($order->status === 'paid')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i> Paid
                                </span>
                            @elseif($order->status === 'shipped')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700">
                                    <i class="fas fa-truck mr-1"></i> Shipped
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection