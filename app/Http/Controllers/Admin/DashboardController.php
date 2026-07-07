<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now              = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endOfLastMonth   = $startOfThisMonth->copy()->subSecond();

        // ── Orders: this month vs previous month ──────────────────
        $currentMonthOrders = Order::where('created_at', '>=', $startOfThisMonth)->count();
        $prevMonthOrders    = Order::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $ordersChange       = (($currentMonthOrders - $prevMonthOrders) / max($prevMonthOrders, 1)) * 100;

        // ── Revenue: this month vs previous month (paid orders only) ──
        $currentMonthRevenue = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startOfThisMonth)
            ->sum('total');

        $prevMonthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');

        $revenueChange = (($currentMonthRevenue - $prevMonthRevenue) / max($prevMonthRevenue, 1)) * 100;

        // ── Customers: frontend users only (excludes staff/admin roles) ──
        $customerQuery = User::whereDoesntHave(
            'roles',
            fn ($q) => $q->whereIn('name', ['super-admin', 'admin', 'editor'])
        );

        $totalCustomers    = (clone $customerQuery)->count();
        $newCustomersToday = (clone $customerQuery)->whereDate('created_at', $now->toDateString())->count();

        // ── Products ────────────────────────────────────────────────
        $totalProducts = Product::count();
        $outOfStock    = Product::active()->where('stock_qty', 0)->count();

        $stats = [
            'total_orders'        => Order::count(),
            'orders_change'       => round($ordersChange, 1),
            'total_revenue'       => Order::where('payment_status', 'paid')->sum('total'),
            'revenue_change'      => round($revenueChange, 1),
            'total_customers'     => $totalCustomers,
            'new_customers_today' => $newCustomersToday,
            'total_products'      => $totalProducts,
            'out_of_stock'        => $outOfStock,
        ];

        $recentOrders = Order::with('user')
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
