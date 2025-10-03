@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Users</a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">User Information</h2>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-600 text-sm">Name</p>
            <p class="text-gray-800 font-semibold">{{ $user->name }} {{ $user->surname }}</p>
        </div>
        <div>
            <p class="text-gray-600 text-sm">Phone Number</p>
            <p class="text-gray-800 font-semibold">{{ $user->phone_number }}</p>
        </div>
        <div>
            <p class="text-gray-600 text-sm">Email</p>
            <p class="text-gray-800 font-semibold">{{ $user->email }}</p>
        </div>
        <div>
            <p class="text-gray-600 text-sm">Member Since</p>
            <p class="text-gray-800 font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h2 class="text-2xl font-bold text-gray-800">Order History</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($user->orders as $order)
                <tr>
                    <td class="px-6 py-4">#{{ $order->id }}</td>
                    <td class="px-6 py-4">{{ $order->product->name }}</td>
                    <td class="px-6 py-4">{{ $order->quantity }}</td>
                    <td class="px-6 py-4">{{ number_format($order->total_price, 2) }} DZD</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($user->orders->count() > 0)
    <div class="p-6 bg-gray-50">
        <p class="text-lg font-semibold text-gray-800">Total Spent: {{ number_format($user->orders->sum('total_price'), 2) }} DZD</p>
    </div>
    @endif
</div>
@endsection