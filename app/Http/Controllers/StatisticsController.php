<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomOrders = CustomOrder::count();
        $totalRevenue = Order::sum('total_price');

        // Growth Statistics (Last 30 days vs Previous 30 days)
        $last30Days = now()->subDays(30);
        $previous60Days = now()->subDays(60);

        $usersLast30 = User::where('created_at', '>=', $last30Days)->count();
        $usersPrevious30 = User::whereBetween('created_at', [$previous60Days, $last30Days])->count();
        $usersGrowth = $usersPrevious30 > 0 ? (($usersLast30 - $usersPrevious30) / $usersPrevious30) * 100 : 0;

        $ordersLast30 = Order::where('created_at', '>=', $last30Days)->count();
        $ordersPrevious30 = Order::whereBetween('created_at', [$previous60Days, $last30Days])->count();
        $ordersGrowth = $ordersPrevious30 > 0 ? (($ordersLast30 - $ordersPrevious30) / $ordersPrevious30) * 100 : 0;

        $revenueLast30 = Order::where('created_at', '>=', $last30Days)->sum('total_price');
        $revenuePrevious30 = Order::whereBetween('created_at', [$previous60Days, $last30Days])->sum('total_price');
        $revenueGrowth = $revenuePrevious30 > 0 ? (($revenueLast30 - $revenuePrevious30) / $revenuePrevious30) * 100 : 0;

        // Monthly Revenue (Last 12 months)
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top Selling Products
        $topProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Order Status Distribution
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Recent Activity
        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(10)
            ->get();

        // Top Customers
        $topCustomers = User::withSum('orders', 'total_price')
            ->orderBy('orders_sum_total_price', 'desc')
            ->take(5)
            ->get();

        // Product Stock Alerts (Low Stock)
        $lowStockProducts = Product::where('stock', '<', 20)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Out of Stock
        $outOfStockProducts = Product::where('stock', '=', 0)->count();

        // Custom Orders Stats
        $customOrdersByStatus = CustomOrder::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('dashboard.statistics', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalCustomOrders',
            'totalRevenue',
            'usersGrowth',
            'ordersGrowth',
            'revenueGrowth',
            'monthlyRevenue',
            'topProducts',
            'ordersByStatus',
            'recentOrders',
            'topCustomers',
            'lowStockProducts',
            'outOfStockProducts',
            'customOrdersByStatus'
        ));
    }
}
