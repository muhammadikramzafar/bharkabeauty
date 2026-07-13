@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page_title', isset($product) ? 'Edit Product' : 'Add Product')
@section('content')

<form method="POST"
      action="{{ isset($product) ? route('admin.products.update',$product) : route('admin.products.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:1.5rem;">
        <strong>Please fix the following before saving:</strong>
        <ul style="margin:.5rem 0 0;padding-left:1.25rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">

            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Product Information</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Product Name <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" value="{{ old('name',$product->name??'') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Huda Beauty Rose Gold Palette"
                               maxlength="255" required
                               oninput="autoSlug(this.value)">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" id="slug"
                                   value="{{ old('slug',$product->slug??'') }}"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   placeholder="auto-generated" maxlength="255">
                            @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>SKU</label>
                            <input type="text" name="sku" value="{{ old('sku',$product->sku??'') }}"
                                   class="form-control @error('sku') is-invalid @enderror"
                                   placeholder="e.g. HB-RGP-001" maxlength="100">
                            @error('sku')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="short_description" rows="2" maxlength="500"
                                  class="form-control @error('short_description') is-invalid @enderror"
                                  placeholder="One-line product summary…"
                                  oninput="document.getElementById('short-desc-len').textContent=this.value.length">{{ old('short_description',$product->short_description??'') }}</textarea>
                        <small class="form-hint"><span id="short-desc-len">{{ strlen(old('short_description',$product->short_description??'')) }}</span>/500 characters</small>
                        @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="description" rows="6"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Detailed product description…">{{ old('description',$product->description??'') }}</textarea>
                        @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Pricing & Stock</h3></div>
                <div class="admin-form">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label>Price (PKR) <span style="color:#ef4444">*</span></label>
                            <input type="number" name="price" step="0.01" min="0"
                                   value="{{ old('price',$product->price??'') }}"
                                   class="form-control @error('price') is-invalid @enderror"
                                   placeholder="0.00" required>
                            @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Sale Price (PKR)</label>
                            <input type="number" name="sale_price" step="0.01" min="0"
                                   value="{{ old('sale_price',$product->sale_price??'') }}"
                                   class="form-control @error('sale_price') is-invalid @enderror"
                                   placeholder="Leave empty for no sale">
                            @error('sale_price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Stock Quantity <span style="color:#ef4444">*</span></label>
                            <input type="number" name="stock_qty" min="0"
                                   value="{{ old('stock_qty',$product->stock_qty??0) }}"
                                   class="form-control @error('stock_qty') is-invalid @enderror" required>
                            @error('stock_qty')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Product Images</h3></div>
                <div class="admin-form">
                    @if(isset($product) && !empty($product->images))
                    <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem;">
                        @foreach($product->images as $img)
                        <img src="{{ Storage::disk('public')->url($img) }}"
                             style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1.5px solid #ede5d8;">
                        @endforeach
                    </div>
                    @endif
                    <input type="file" name="images[]" accept="image/*" multiple
                           class="form-control @error('images.*') is-invalid @enderror">
                    <small class="form-hint">Upload multiple images. First image will be used as the main product image. Max 3MB each.</small>
                    @error('images.*')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">SEO</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" maxlength="160"
                               value="{{ old('seo_title',$product->seo_title??'') }}"
                               class="form-control @error('seo_title') is-invalid @enderror"
                               oninput="document.getElementById('seo-title-len').textContent=this.value.length">
                        <small class="form-hint"><span id="seo-title-len">{{ strlen(old('seo_title',$product->seo_title??'')) }}</span>/160 characters</small>
                        @error('seo_title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea name="seo_description" rows="2" maxlength="320"
                                  class="form-control @error('seo_description') is-invalid @enderror"
                                  oninput="document.getElementById('seo-desc-len').textContent=this.value.length">{{ old('seo_description',$product->seo_description??'') }}</textarea>
                        <small class="form-hint"><span id="seo-desc-len">{{ strlen(old('seo_description',$product->seo_description??'')) }}</span>/320 characters</small>
                        @error('seo_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>SEO Keywords</label>
                        <input type="text" name="seo_keywords" maxlength="255"
                               value="{{ old('seo_keywords',$product->seo_keywords??'') }}"
                               class="form-control @error('seo_keywords') is-invalid @enderror">
                        @error('seo_keywords')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Publish</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active',$product->is_active??true)?'selected':'' }}>Active</option>
                            <option value="0" {{ !old('is_active',$product->is_active??true)?'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                            <input type="checkbox" name="is_featured" value="1"
                                   {{ old('is_featured',$product->is_featured??false)?'checked':'' }}
                                   style="width:16px;height:16px;accent-color:#c9a96e;">
                            Mark as Featured
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" min="0"
                               value="{{ old('sort_order',$product->sort_order??0) }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-full" style="margin-top:.5rem;">Cancel</a>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Category & Brand</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">— None —</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id',$product->category_id??'')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                            <option value="">— None —</option>
                            @foreach($brands as $b)
                            <option value="{{ $b->id }}" {{ old('brand_id',$product->brand_id??'')==$b->id?'selected':'' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@push('scripts')
<script>
function autoSlug(v) {
    const s = document.getElementById('slug');
    if (!s.dataset.edited) {
        s.value = v.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    }
}
document.getElementById('slug').addEventListener('input', function() { this.dataset.edited = '1'; });
</script>
@endpush
