@extends('layouts.admin')
@section('title','Import Categories')
@section('page_title','Bulk Import Categories')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">← Back to Categories</a>
    <a href="{{ route('admin.categories.export') }}" class="btn btn-outline btn-sm">Download Current Categories (CSV)</a>
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
            <table class="admin-table" style="min-width:600px;">
                <thead><tr><th>Column</th><th>Required</th><th>Notes</th></tr></thead>
                <tbody>
                    <tr><td><code>id</code></td><td>No</td><td>Leave blank when creating new. Set to update an existing category by ID.</td></tr>
                    <tr><td><code>name</code></td><td>Yes</td><td>Category name.</td></tr>
                    <tr><td><code>slug</code></td><td>No</td><td>Auto-generated from name if left blank. Used to match existing rows when <code>id</code> isn't given.</td></tr>
                    <tr><td><code>description</code></td><td>No</td><td>Max 500 characters.</td></tr>
                    <tr><td><code>image</code></td><td>No</td><td>Filename of an image placed in <code>storage/app/import/categories/</code> (see below), or an existing stored path to leave unchanged.</td></tr>
                    <tr><td><code>parent_slug</code></td><td>No</td><td>Slug of an existing parent category, for subcategories.</td></tr>
                    <tr><td><code>sort_order</code></td><td>No</td><td>Integer, defaults to 0.</td></tr>
                    <tr><td><code>is_active</code></td><td>No</td><td><code>1</code> or <code>0</code>. Defaults to active.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="alert alert-warning" style="margin-top:1.25rem;">
            <strong>Image folder path:</strong> before importing, upload your image files to
            <code>storage/app/import/categories/</code> on the server. Reference each file by its
            exact filename (e.g. <code>skincare.jpg</code>) in the <code>image</code> column — the
            import will copy it into <code>storage/app/public/categories/</code> automatically.
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h3 class="admin-card-title">Upload CSV</h3></div>
    <div class="admin-form">
        <form method="POST" action="{{ route('admin.categories.import.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>CSV File <span style="color:#ef4444">*</span></label>
                <input type="file" name="csv_file" accept=".csv,text/csv" class="form-control @error('csv_file') is-invalid @enderror" required>
                @error('csv_file')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Import Categories</button>
        </form>
    </div>
</div>

@endsection
