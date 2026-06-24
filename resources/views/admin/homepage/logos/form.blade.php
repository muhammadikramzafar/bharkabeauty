@extends('layouts.admin')
@section('title', $logo->exists ? 'Edit Logo' : 'New Logo')
@section('page_title', $logo->exists ? 'Edit Client Logo' : 'Add Client Logo')

@section('content')

<form method="POST"
      action="{{ $logo->exists ? route('admin.homepage.logos.update', $logo) : route('admin.homepage.logos.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($logo->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Brand Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $logo->name) }}" class="form-control @error('name') is-invalid @enderror" required maxlength="100">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tagline / Category <span class="form-hint">e.g. Makeup, Skincare</span></label>
                        <input type="text" name="tagline" value="{{ old('tagline', $logo->tagline) }}" maxlength="60" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Logo Image <span class="form-hint">PNG with transparency recommended</span></label>
                        @if($logo->logo_url)
                            <div style="margin-bottom:.5rem;background:#f9fafb;padding:.5rem;border-radius:8px;display:inline-block;">
                                <img src="{{ $logo->logo_url }}" style="max-height:60px;object-fit:contain;">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="form-control">
                        <small class="form-hint">Leave empty to use text-only brand card</small>
                    </div>
                    <div class="form-group">
                        <label>Link URL <span class="form-hint">where the logo links to</span></label>
                        <input type="text" name="url" value="{{ old('url', $logo->url) }}" placeholder="/shop?brand=brandname" class="form-control" maxlength="255">
                    </div>
                </div>
            </div>
        </div>
        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Options</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $logo->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $logo->is_active ?? true) ? 'checked' : '' }}>
                            Active (show on homepage)
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $logo->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.logos.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
