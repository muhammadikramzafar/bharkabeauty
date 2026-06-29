<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        $subtotal  = collect($cartItems)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $savings   = collect($cartItems)->sum(fn ($i) => isset($i['original_price']) ? ($i['original_price'] - $i['price']) * $i['quantity'] : 0);
        $coupon    = session('coupon');

        return view('cart', compact('cartItems', 'subtotal', 'savings', 'coupon'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:10',
        ]);

        $product = Product::with('brand')->findOrFail($request->product_id);
        $cart    = session('cart', []);
        $id      = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(10, $cart[$id]['quantity'] + (int) $request->quantity);
        } else {
            $effectivePrice = (float) ($product->sale_price ?? $product->price);
            $cart[$id] = [
                'id'             => $product->id,
                'name'           => $product->name,
                'slug'           => $product->slug,
                'brand'          => $product->brand?->name ?? '',
                'price'          => $effectivePrice,
                'original_price' => (float) $product->price,
                'quantity'       => (int) $request->quantity,
                'image'          => $product->main_image,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Item added to your bag!');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $id   = $request->item_id;

        if (isset($cart[$id])) {
            $qty = max(1, min(10, (int) $request->quantity));
            $cart[$id]['quantity'] = $qty;
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
        $code = strtoupper(trim($request->input('coupon', '')));

        if (empty($code)) {
            return redirect()->route('cart')->with('error', 'Please enter a coupon code.');
        }

        $cartItems = session('cart', []);
        $subtotal  = collect($cartItems)->sum(fn ($i) => $i['price'] * $i['quantity']);

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return redirect()->route('cart')->with('error', "Coupon \"{$code}\" is not valid.");
        }

        if (!$coupon->isValid($subtotal)) {
            if ($subtotal < $coupon->min_order) {
                return redirect()->route('cart')->with('error',
                    "Minimum order of PKR " . number_format($coupon->min_order) . " required to use this coupon.");
            }
            return redirect()->route('cart')->with('error', 'This coupon has expired or is no longer available.');
        }

        $discount = $coupon->discountAmount($subtotal);

        session(['coupon' => [
            'code'     => $coupon->code,
            'type'     => $coupon->type,
            'value'    => $coupon->value,
            'discount' => $discount,
        ]]);

        $label = $coupon->type === 'percent' ? "{$coupon->value}% off" : "PKR " . number_format($coupon->value) . " off";
        return redirect()->route('cart')->with('success', "Coupon \"{$coupon->code}\" applied — {$label}! You save PKR " . number_format($discount) . ".");
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->route('cart')->with('info', 'Coupon removed.');
    }
}
