<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $productId = (int) $request->input('product_id');
        $wishlist  = session('wishlist', []);

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
            $inWishlist = false;
            $message    = 'Removed from wishlist';
        } else {
            $product = Product::with('brand')->find($productId);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            $wishlist[$productId] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'slug'  => $product->slug,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->main_image,
                'brand' => $product->brand->name ?? '',
            ];
            $inWishlist = true;
            $message    = 'Added to wishlist ♡';
        }

        session(['wishlist' => $wishlist]);

        return response()->json([
            'in_wishlist' => $inWishlist,
            'count'       => count($wishlist),
            'message'     => $message,
        ]);
    }

    public function index()
    {
        $wishlistItems = session('wishlist', []);
        return view('wishlist', compact('wishlistItems'));
    }

    public function remove(Request $request)
    {
        $productId = (int) $request->input('product_id');
        $wishlist  = session('wishlist', []);
        unset($wishlist[$productId]);
        session(['wishlist' => $wishlist]);
        return redirect()->route('wishlist')->with('success', 'Item removed from wishlist.');
    }
}
