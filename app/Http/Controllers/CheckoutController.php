<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('checkout', ['step' => 1]);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:255',
            'city'       => 'required|string|max:100',
        ]);

        session(['checkout_address' => $request->only('first_name', 'phone', 'address', 'city', 'postal_code')]);

        return view('checkout', ['step' => 2]);
    }

    public function storeDelivery(Request $request)
    {
        $request->validate(['delivery_method' => 'required|in:standard,express,same_day']);
        session(['checkout_delivery' => $request->delivery_method]);

        return view('checkout', ['step' => 3]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate(['payment_method' => 'required|in:cod,jazzcash,easypaisa,card']);

        session()->forget(['cart', 'checkout_address', 'checkout_delivery']);

        return redirect()->route('home')->with('success', 'Order placed successfully! You will receive a confirmation shortly.');
    }
}
