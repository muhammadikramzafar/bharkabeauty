@extends('layouts.admin')
@section('title', isset($banner) && $banner->exists ? 'Edit Banner' : 'New Banner')
@section('page_title', isset($banner) && $banner->exists ? 'Edit Banner' : 'Add Banner')

@section('content')

@php $item = $banner ?? new \App\Models\HomepageBanner; @endphp

<form method="POST"
      action="{{ $item->exists ? route('admin.homepage.banners.update', $item) : route('admin.homepage.banners.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($item->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Badge Text <span class="form-hint">e.g. "27% OFF", "New In"</span></label>
                        <input type="text" name="badge_text" value="{{ old('badge_text', $item->badge_text) }}" maxlength="40" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $item->subtitle) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        @if($item->image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $item->image_url }}" alt="" style="max-height:120px;border-radius:8px;"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control">
                        <small class="form-hint">Recommended: wide landscape image</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $item->button_text) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Button URL</label>
                            <input type="text" name="button_url" value="{{ old('button_url', $item->button_url) }}" class="form-control">
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
                        <label>Position</label>
                        <select name="position" class="form-control">
                            @foreach(['top','middle','bottom'] as $pos)
                                <option value="{{ $pos }}" {{ old('position', $item->position ?? 'middle') == $pos ? 'selected' : '' }}>{{ ucfirst($pos) }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <a href="{{ route('admin.homepage.banners.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
