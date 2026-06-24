<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        $subtotal  = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
        $savings   = collect($cartItems)->sum(fn($i) => isset($i['original_price']) ? ($i['original_price'] - $i['price']) * $i['quantity'] : 0);

        return view('cart', compact('cartItems', 'subtotal', 'savings'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1|max:10',
        ]);

        $cart = session('cart', []);
        $id   = $request->product_id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'id'       => $id,
                'name'     => $request->name ?? 'Product',
                'price'    => $request->price ?? 0,
                'quantity' => $request->quantity,
                'image'    => $request->image ?? null,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Item added to bag!');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $id   = $request->item_id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int) $request->quantity);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->item_id]);
        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Item removed from bag.');
    }

    public function applyCoupon(Request $request)
    {
        return redirect()->route('cart')->with('info', 'Coupon feature coming soon.');
    }
}
