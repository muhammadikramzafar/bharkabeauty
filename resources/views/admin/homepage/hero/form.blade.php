@extends('layouts.admin')
@section('title', $slide->exists ? 'Edit Slide' : 'New Slide')
@section('page_title', $slide->exists ? 'Edit Hero Slide' : 'Add Hero Slide')

@section('content')

<form method="POST"
      action="{{ $slide->exists ? route('admin.homepage.hero.update', $slide) : route('admin.homepage.hero.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($slide->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Eyebrow Text <span class="form-hint">small line above headline</span></label>
                        <input type="text" name="eyebrow" value="{{ old('eyebrow', $slide->eyebrow) }}" placeholder="e.g. New Season, New Glow" class="form-control @error('eyebrow') is-invalid @enderror" maxlength="80">
                        @error('eyebrow')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Headline <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $slide->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Headline Highlight <span class="form-hint">part in accent color (e.g. "Our Craft")</span></label>
                        <input type="text" name="title_highlight" value="{{ old('title_highlight', $slide->title_highlight) }}" class="form-control" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control" maxlength="400">{{ old('description', $slide->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Badge Text <span class="form-hint">circular badge, e.g. "Premium Beauty"</span></label>
                        <input type="text" name="badge_text" value="{{ old('badge_text', $slide->badge_text) }}" class="form-control" maxlength="60">
                    </div>
                    <div class="form-group">
                        <label>Background Image</label>
                        @if($slide->image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $slide->image_url }}" alt="Current" style="max-height:120px;border-radius:8px;"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                        <small class="form-hint">Recommended: 1440×720px</small>
                        @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">CTA Buttons</h3></div>
                <div class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button 1 Text</label>
                            <input type="text" name="button1_text" value="{{ old('button1_text', $slide->button1_text) }}" placeholder="Shop Now" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Button 1 URL</label>
                            <input type="text" name="button1_url" value="{{ old('button1_url', $slide->button1_url) }}" placeholder="/shop" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button 2 Text</label>
                            <input type="text" name="button2_text" value="{{ old('button2_text', $slide->button2_text) }}" placeholder="Explore Brands" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Button 2 URL</label>
                            <input type="text" name="button2_url" value="{{ old('button2_url', $slide->button2_url) }}" placeholder="/brands" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Publish</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}>
                            Active (show on homepage)
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $slide->exists ? 'Update Slide' : 'Create Slide' }}</button>
                        <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
