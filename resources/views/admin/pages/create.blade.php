@extends('layouts.admin')
@section('title', 'Create Page')
@section('page_title', 'Create Page')

@section('content')
<form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="page-editor-layout">

        {{-- Main Content --}}
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" id="page-title" value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror" required
                               oninput="autoSlug(this.value)">
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Slug <span class="required">*</span></label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/</span>
                            <input type="text" name="slug" id="page-slug" value="{{ old('slug') }}"
                                   class="form-control @error('slug') is-invalid @enderror" required>
                        </div>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="banner_image" accept="image/*"
                               class="form-control @error('banner_image') is-invalid @enderror">
                        @error('banner_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="page-description" rows="12"
                                  class="form-control richtext">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">SEO</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title') }}" maxlength="160" class="form-control">
                        <small class="form-hint">Defaults to page title if empty · Max 160 chars</small>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea name="seo_description" rows="3" maxlength="320" class="form-control">{{ old('seo_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Keywords</label>
                        <input type="text" name="seo_keywords" value="{{ old('seo_keywords') }}" placeholder="beauty, skincare, makeup" class="form-control">
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
                        <select name="status" class="form-control">
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft"     {{ old('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">Publish Page</button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script>
function autoSlug(val) {
    const slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    document.getElementById('page-slug').value = slug;
}
</script>
@endpush
