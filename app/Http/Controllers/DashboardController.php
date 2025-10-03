<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $totalRevenue = Order::sum('total_price');

        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('dashboard.index', compact(
            'userCount',
            'productCount',
            'orderCount',
            'totalRevenue',
            'recentOrders',
            'revenueData',
            'ordersByStatus'
        ));
    }
}
