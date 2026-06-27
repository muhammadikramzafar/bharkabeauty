<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    private function cartData(): array
    {
        $items    = session('cart', []);
        $subtotal = collect($items)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $delivery = $subtotal >= 2000 ? 0 : 150;
        return compact('items', 'subtotal', 'delivery');
    }

    public function index()
    {
        $cart    = $this->cartData();
        $address = session('checkout_address', [
            'first_name'  => Auth::user()->name ?? '',
            'phone'       => '',
            'address'     => '',
            'city'        => '',
            'postal_code' => '',
        ]);

        return view('checkout', array_merge($cart, ['step' => 1, 'address' => $address]));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'email'      => 'required|email|max:255',
            'address'    => 'required|string|max:255',
            'city'       => 'required|string|max:100',
        ]);

        session(['checkout_address' => $request->only('first_name', 'phone', 'email', 'address', 'city', 'postal_code')]);

        $cart = $this->cartData();
        return view('checkout', array_merge($cart, ['step' => 2]));
    }

    public function storeDelivery(Request $request)
    {
        $request->validate(['delivery_method' => 'required|in:standard,express,same_day']);
        session(['checkout_delivery' => $request->delivery_method]);

        $cart = $this->cartData();
        return view('checkout', array_merge($cart, ['step' => 3]));
    }

    public function placeOrder(Request $request)
    {
        $request->validate(['payment_method' => 'required|in:cod,jazzcash,easypaisa']);

        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your bag is empty.');
        }

        $address  = session('checkout_address', []);
        $subtotal = collect($cartItems)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $delivery = $subtotal >= 2000 ? 0 : 150;
        $total    = $subtotal + $delivery;

        // Create order record
        $order = Order::create([
            'user_id'          => Auth::id(),
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'unpaid',
            'subtotal'         => $subtotal,
            'discount'         => 0,
            'shipping'         => $delivery,
            'total'            => $total,
            'shipping_address' => $address,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'qty'          => $item['quantity'],
                'total'        => $item['price'] * $item['quantity'],
            ]);
        }

        $order->load('items', 'user');

        // Email customer
        try {
            Mail::to(Auth::user()->email)
                ->send(new OrderConfirmationMail($order, false));
        } catch (\Throwable $e) {
            logger()->error('Customer order email failed: ' . $e->getMessage());
        }

        // Email admin
        try {
            Mail::to(config('mail.admin_email', 'superadmin@bharkabeauty.com'))
                ->send(new OrderConfirmationMail($order, true));
        } catch (\Throwable $e) {
            logger()->error('Admin order email failed: ' . $e->getMessage());
        }

        // Clear cart + checkout session
        session()->forget(['cart', 'checkout_address', 'checkout_delivery']);

        return redirect()->route('order.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('order-success', compact('order'));
    }
}
