<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function export(): StreamedResponse
    {
        $products = Product::with(['category', 'brand'])->orderBy('name')->get();

        return response()->streamDownload(function () use ($products) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'id', 'category_slug', 'brand_slug', 'name', 'slug', 'sku',
                'short_description', 'description', 'price', 'sale_price', 'stock_qty',
                'image', 'additional_images', 'is_featured', 'is_active', 'sort_order',
                'seo_title', 'seo_description', 'seo_keywords',
            ]);
            foreach ($products as $p) {
                $images = $p->images ?? [];
                fputcsv($handle, [
                    $p->id, $p->category?->slug, $p->brand?->slug, $p->name, $p->slug, $p->sku,
                    $p->short_description, $p->description, $p->price, $p->sale_price, $p->stock_qty,
                    $images[0] ?? '', implode('|', array_slice($images, 1)),
                    $p->is_featured ? 1 : 0, $p->is_active ? 1 : 0, $p->sort_order,
                    $p->seo_title, $p->seo_description, $p->seo_keywords,
                ]);
            }
            fclose($handle);
        }, 'products-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function importForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:10240']);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        $header = array_map(fn ($h) => strtolower(trim($h)), fgetcsv($handle));

        $importDir = storage_path('app/import/products');
        $created   = 0;
        $updated   = 0;
        $errors    = [];
        $rowNum    = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }
            $data = array_combine($header, array_pad($row, count($header), null));

            try {
                Validator::make($data, [
                    'name'              => 'required|string|max:255',
                    'slug'              => 'nullable|string|max:255',
                    'sku'               => 'nullable|string|max:100',
                    'short_description' => 'nullable|string|max:500',
                    'price'             => 'required|numeric|min:0',
                    'sale_price'        => 'nullable|numeric|min:0',
                    'stock_qty'         => 'required|integer|min:0',
                    'seo_title'         => 'nullable|string|max:160',
                    'seo_description'   => 'nullable|string|max:320',
                    'seo_keywords'      => 'nullable|string|max:255',
                ])->validate();

                $slug = trim((string) ($data['slug'] ?? '')) ?: Str::slug($data['name']);

                $product = null;
                if (! empty($data['id'])) {
                    $product = Product::find($data['id']);
                }
                if (! $product) {
                    $product = Product::where('slug', $slug)->first();
                }

                $slugClash = Product::where('slug', $slug)->when($product, fn ($q) => $q->where('id', '!=', $product->id))->exists();
                if ($slugClash) {
                    throw new \RuntimeException("slug '{$slug}' is already used by another product");
                }

                if (! empty($data['sku'])) {
                    $skuClash = Product::where('sku', trim($data['sku']))->when($product, fn ($q) => $q->where('id', '!=', $product->id))->exists();
                    if ($skuClash) {
                        throw new \RuntimeException("sku '{$data['sku']}' is already used by another product");
                    }
                }

                $categoryId = null;
                if (! empty($data['category_slug'])) {
                    $category = Category::where('slug', trim($data['category_slug']))->first();
                    if (! $category) {
                        throw new \RuntimeException("category_slug '{$data['category_slug']}' not found");
                    }
                    $categoryId = $category->id;
                }

                $brandId = null;
                if (! empty($data['brand_slug'])) {
                    $brand = Brand::where('slug', trim($data['brand_slug']))->first();
                    if (! $brand) {
                        throw new \RuntimeException("brand_slug '{$data['brand_slug']}' not found");
                    }
                    $brandId = $brand->id;
                }

                $payload = [
                    'category_id'       => $categoryId,
                    'brand_id'          => $brandId,
                    'name'              => $data['name'],
                    'slug'              => $slug,
                    'sku'               => $data['sku'] ?: null,
                    'short_description' => $data['short_description'] ?: null,
                    'description'       => $data['description'] ?: null,
                    'price'             => (float) $data['price'],
                    'sale_price'        => $data['sale_price'] !== '' && $data['sale_price'] !== null ? (float) $data['sale_price'] : null,
                    'stock_qty'         => (int) $data['stock_qty'],
                    'is_featured'       => filter_var($data['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'is_active'         => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'sort_order'        => (int) ($data['sort_order'] ?? 0),
                    'seo_title'         => $data['seo_title'] ?: null,
                    'seo_description'   => $data['seo_description'] ?: null,
                    'seo_keywords'      => $data['seo_keywords'] ?: null,
                ];

                $imageValues = [];
                if (! empty($data['image'])) {
                    $imageValues[] = trim($data['image']);
                }
                if (! empty($data['additional_images'])) {
                    foreach (explode('|', $data['additional_images']) as $extra) {
                        $extra = trim($extra);
                        if ($extra !== '') $imageValues[] = $extra;
                    }
                }

                if ($imageValues) {
                    $images = [];
                    foreach ($imageValues as $imageValue) {
                        if (Storage::disk('public')->exists($imageValue)) {
                            $images[] = $imageValue;
                            continue;
                        }

                        $sourceFile = $importDir . DIRECTORY_SEPARATOR . basename($imageValue);
                        if (file_exists($sourceFile)) {
                            $ext          = pathinfo($sourceFile, PATHINFO_EXTENSION);
                            $destRelative = 'products/' . Str::random(20) . ($ext ? ".{$ext}" : '');
                            Storage::disk('public')->put($destRelative, file_get_contents($sourceFile));
                            $images[] = $destRelative;
                        } else {
                            $errors[] = "Row {$rowNum}: image file '{$imageValue}' not found in storage/app/import/products/";
                        }
                    }
                    if ($images) {
                        $payload['images'] = $images;
                    }
                }

                if ($product) {
                    $product->update($payload);
                    $updated++;
                } else {
                    Product::create($payload);
                    $created++;
                }
            } catch (\Throwable $e) {
                $errors[] = "Row {$rowNum}: " . $e->getMessage();
            }
        }
        fclose($handle);

        return back()->with('import_result', compact('created', 'updated', 'errors'));
    }
}
