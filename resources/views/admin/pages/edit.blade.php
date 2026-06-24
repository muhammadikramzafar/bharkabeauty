@extends('layouts.admin')
@section('title', 'Edit: ' . $page->title)
@section('page_title', 'Edit Page')

@section('content')
<form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="page-editor-layout">

        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}"
                               class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Slug <span class="required">*</span></label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/</span>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                                   class="form-control @error('slug') is-invalid @enderror" required>
                        </div>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        @if($page->banner_image)
                            <div class="media-preview">
                                <img src="{{ Storage::disk('public')->url($page->banner_image) }}" alt="Banner" style="max-height:120px; border-radius:8px;">
                            </div>
                        @endif
                        <input type="file" name="banner_image" accept="image/*" class="form-control">
                        <small class="form-hint">Upload a new image to replace the current one.</small>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="14" class="form-control richtext">{{ old('description', $page->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">SEO</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title) }}" maxlength="160" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea name="seo_description" rows="3" maxlength="320" class="form-control">{{ old('seo_description', $page->seo_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Keywords</label>
                        <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $page->seo_keywords) }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Publish</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft"     {{ $page->status == 'draft'     ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">Update Page</button>
                        <a href="{{ route('cms.page', $page->slug) }}" target="_blank" class="btn btn-outline btn-full">View Page</a>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-full">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
