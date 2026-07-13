<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])->latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('sku', 'like', "%$s%"));
        }
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('brand'))    $query->where('brand_id', $request->brand);
        if ($request->filled('status'))   $query->where('is_active', $request->status === 'active');
        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        return view('admin.products.form', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:products,slug',
            'category_id'       => 'nullable|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'sku'               => 'nullable|string|max:100|unique:products,sku',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock_qty'         => 'required|integer|min:0',
            'seo_title'         => 'nullable|string|max:160',
            'seo_description'   => 'nullable|string|max:320',
            'seo_keywords'      => 'nullable|string|max:255',
            'images.*'          => 'nullable|image|max:3072',
        ]);
        $data['slug']        = ($data['slug'] ?? null) ?: Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = (int) $request->input('sort_order', 0);
        $images = [];
        foreach ($request->file('images', []) as $file) {
            $images[] = $file->store('products', 'public');
        }
        if ($images) $data['images'] = $images;
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id'       => 'nullable|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'sku'               => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock_qty'         => 'required|integer|min:0',
            'seo_title'         => 'nullable|string|max:160',
            'seo_description'   => 'nullable|string|max:320',
            'seo_keywords'      => 'nullable|string|max:255',
            'images.*'          => 'nullable|image|max:3072',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = (int) $request->input('sort_order', 0);
        $images = $product->images ?? [];
        foreach ($request->file('images', []) as $file) {
            $images[] = $file->store('products', 'public');
        }
        $data['images'] = $images;
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images ?? [] as $img) {
            Storage::disk('public')->delete($img);
        }
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
