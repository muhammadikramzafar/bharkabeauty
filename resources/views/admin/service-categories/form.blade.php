@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('page_title', $category->exists ? 'Edit Service Category' : 'New Service Category')

@section('content')

<form method="POST"
      action="{{ $category->exists ? route('admin.service-categories.update', $category) : route('admin.service-categories.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($category->exists) @method('PUT') @endif

    <div class="page-editor-layout">

        {{-- Main --}}
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">

                    <div class="form-group">
                        <label>Category Name <span class="required">*</span></label>
                        <input type="text" name="name" id="cat-name"
                               value="{{ old('name', $category->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               required maxlength="120">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Slug <span class="form-hint">auto-generated from name</span></label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/services?category=</span>
                            <input type="text" name="slug" id="cat-slug"
                                   value="{{ old('slug', $category->slug) }}"
                                   class="form-control @error('slug') is-invalid @enderror">
                        </div>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" maxlength="1000"
                                  class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Category Image</label>
                        @if($category->image_url)
                            <div style="margin-bottom:.5rem;">
                                <img src="{{ $category->image_url }}" style="max-height:100px;border-radius:8px;">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="form-control @error('image') is-invalid @enderror">
                        <small class="form-hint">Recommended: 400×300px</small>
                        @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Options</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                               min="0" class="form-control">
                        <small class="form-hint">Lower = appears first</small>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            Active (visible on frontend)
                        </label>
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">
                            {{ $category->exists ? 'Update Category' : 'Create Category' }}
                        </button>
                        <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
// Auto-generate slug from name
const nameInput = document.getElementById('cat-name');
const slugInput = document.getElementById('cat-slug');
let slugEdited  = {{ $category->exists ? 'true' : 'false' }};

slugInput.addEventListener('input', () => slugEdited = true);
nameInput.addEventListener('input', () => {
    if (slugEdited) return;
    slugInput.value = nameInput.value
        .toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});
</script>
@endpush
