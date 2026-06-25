<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['category', 'brand'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Related products: same sub-category, exclude self, limit 4
        $related = Product::with(['category', 'brand'])
            ->active()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                if ($product->category_id) {
                    $q->where('category_id', $product->category_id);
                }
                if ($product->brand_id) {
                    $q->orWhere('brand_id', $product->brand_id);
                }
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'related'));
    }
}
