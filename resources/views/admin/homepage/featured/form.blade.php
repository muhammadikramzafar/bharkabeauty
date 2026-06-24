@extends('layouts.admin')
@section('title', $item->exists ? 'Edit Collection' : 'New Collection')
@section('page_title', $item->exists ? 'Edit Featured Collection' : 'Add Featured Collection')

@section('content')

<form method="POST"
      action="{{ $item->exists ? route('admin.homepage.featured.update', $item) : route('admin.homepage.featured.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($item->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Eyebrow <span class="form-hint">e.g. Collection, New In, Trending</span></label>
                        <input type="text" name="eyebrow" value="{{ old('eyebrow', $item->eyebrow) }}" maxlength="60" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" maxlength="400" class="form-control">{{ old('description', $item->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Image <span class="form-hint">Landscape, 624×240px recommended</span></label>
                        @if($item->image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $item->image_url }}" style="max-height:100px;border-radius:8px;"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $item->button_text) }}" placeholder="Shop Now" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Button URL</label>
                            <input type="text" name="button_url" value="{{ old('button_url', $item->button_url) }}" placeholder="/shop?col=bestsellers" class="form-control">
                        </div>
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
                        <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $item->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.featured.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
