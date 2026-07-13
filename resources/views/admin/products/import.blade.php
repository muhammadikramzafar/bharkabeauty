@extends('layouts.admin')
@section('title','Import Products')
@section('page_title','Bulk Import Products')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">← Back to Products</a>
    <a href="{{ route('admin.products.export') }}" class="btn btn-outline btn-sm">Download Current Products (CSV)</a>
</div>

@if(session('import_result'))
@php $r = session('import_result'); @endphp
<div class="alert {{ $r['errors'] ? 'alert-warning' : 'alert-success' }}" style="margin-bottom:1.5rem;">
    <strong>{{ $r['created'] }} created, {{ $r['updated'] }} updated.</strong>
    @if($r['errors'])
    <ul style="margin:.5rem 0 0;padding-left:1.25rem;">
        @foreach($r['errors'] as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
</div>
@endif

<div class="admin-card" style="margin-bottom:1.5rem;">
    <div class="admin-card-header"><h3 class="admin-card-title">CSV Format</h3></div>
    <div class="admin-form">
        <p style="font-size:.875rem;color:#6b7280;margin-bottom:1rem;">
            The CSV must include a header row with these columns:
        </p>
        <div class="admin-table" style="overflow-x:auto;">
            <table class="admin-table" style="min-width:700px;">
                <thead><tr><th>Column</th><th>Required</th><th>Notes</th></tr></thead>
                <tbody>
                    <tr><td><code>id</code></td><td>No</td><td>Leave blank when creating new. Set to update an existing product by ID.</td></tr>
                    <tr><td><code>category_slug</code></td><td>No</td><td>Slug of an existing category.</td></tr>
                    <tr><td><code>brand_slug</code></td><td>No</td><td>Slug of an existing brand.</td></tr>
                    <tr><td><code>name</code></td><td>Yes</td><td>Product name.</td></tr>
                    <tr><td><code>slug</code></td><td>No</td><td>Auto-generated from name if left blank. Used to match existing rows when <code>id</code> isn't given.</td></tr>
                    <tr><td><code>sku</code></td><td>No</td><td>Must be unique across products.</td></tr>
                    <tr><td><code>short_description</code></td><td>No</td><td>Max 500 characters.</td></tr>
                    <tr><td><code>description</code></td><td>No</td><td>Full description, no length limit.</td></tr>
                    <tr><td><code>price</code></td><td>Yes</td><td>Numeric, PKR.</td></tr>
                    <tr><td><code>sale_price</code></td><td>No</td><td>Numeric, must be less than price to show as on sale.</td></tr>
                    <tr><td><code>stock_qty</code></td><td>Yes</td><td>Integer.</td></tr>
                    <tr><td><code>image</code></td><td>No</td><td>Filename of the main product image, from <code>storage/app/import/products/</code> (see below).</td></tr>
                    <tr><td><code>additional_images</code></td><td>No</td><td>Filenames of extra gallery images, separated by <code>|</code> (e.g. <code>back.jpg|swatch.jpg</code>).</td></tr>
                    <tr><td><code>is_featured</code></td><td>No</td><td><code>1</code> or <code>0</code>.</td></tr>
                    <tr><td><code>is_active</code></td><td>No</td><td><code>1</code> or <code>0</code>. Defaults to active.</td></tr>
                    <tr><td><code>sort_order</code></td><td>No</td><td>Integer, defaults to 0.</td></tr>
                    <tr><td><code>seo_title</code></td><td>No</td><td>Max 160 characters.</td></tr>
                    <tr><td><code>seo_description</code></td><td>No</td><td>Max 320 characters.</td></tr>
                    <tr><td><code>seo_keywords</code></td><td>No</td><td>Max 255 characters.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="alert alert-warning" style="margin-top:1.25rem;">
            <strong>Image folder path:</strong> before importing, upload your image files to
            <code>storage/app/import/products/</code> on the server. Reference the main image's
            filename in <code>image</code>, and any extra images in <code>additional_images</code>
            separated by <code>|</code> — the import will copy them all into
            <code>storage/app/public/products/</code> automatically.
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h3 class="admin-card-title">Upload CSV</h3></div>
    <div class="admin-form">
        <form method="POST" action="{{ route('admin.products.import.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>CSV File <span style="color:#ef4444">*</span></label>
                <input type="file" name="csv_file" accept=".csv,text/csv" class="form-control @error('csv_file') is-invalid @enderror" required>
                @error('csv_file')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Import Products</button>
        </form>
    </div>
</div>

@endsection
