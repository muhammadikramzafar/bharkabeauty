<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function dashboard()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $total  = Order::where('user_id', $user->id)->sum('total');
        $count  = Order::where('user_id', $user->id)->count();

        return view('profile.dashboard', compact('user', 'orders', 'total', 'count'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    public function orderDetail(string $orderNumber)
    {
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('profile.order-detail', compact('order'));
    }

    public function settings()
    {
        return view('profile.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->update($request->only('name', 'phone'));

        return back()->with('success', 'Profile updated successfully.');
    }
}
