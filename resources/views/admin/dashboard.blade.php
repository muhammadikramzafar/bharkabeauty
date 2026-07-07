@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    <!-- Stats Cards -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="stat-icon stat-icon--orders">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Orders</p>
                <p class="stat-value">{{ $stats['total_orders'] ?? 0 }}</p>
                <p class="stat-change {{ ($stats['orders_change'] ?? 0) >= 0 ? 'up' : 'down' }}">
                    {{ ($stats['orders_change'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['orders_change'] ?? 0 }}% this month
                </p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon stat-icon--revenue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value">PKR {{ number_format($stats['total_revenue'] ?? 0) }}</p>
                <p class="stat-change {{ ($stats['revenue_change'] ?? 0) >= 0 ? 'up' : 'down' }}">
                    {{ ($stats['revenue_change'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['revenue_change'] ?? 0 }}% this month
                </p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon stat-icon--customers">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Customers</p>
                <p class="stat-value">{{ $stats['total_customers'] ?? 0 }}</p>
                <p class="stat-change up">+{{ $stats['new_customers_today'] ?? 0 }} new today</p>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon stat-icon--products">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Products</p>
                <p class="stat-value">{{ $stats['total_products'] ?? 0 }}</p>
                <p class="stat-change {{ ($stats['out_of_stock'] ?? 0) > 0 ? 'warning' : '' }}">{{ $stats['out_of_stock'] ?? 0 }} out of stock</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="admin-card-action">View All</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->items_count }} items</td>
                            <td>PKR {{ number_format($order->total) }}</td>
                            <td><span class="order-status order-status--{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="admin-table-action">View</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
