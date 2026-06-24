@extends('layouts.admin')
@section('title', $cta->exists ? 'Edit CTA' : 'New CTA')
@section('page_title', $cta->exists ? 'Edit CTA Section' : 'Add CTA Section')

@section('content')

<form method="POST"
      action="{{ $cta->exists ? route('admin.homepage.cta.update', $cta) : route('admin.homepage.cta.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($cta->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Section Key <span class="required">*</span> <span class="form-hint">unique identifier, e.g. flagship_store</span></label>
                        <input type="text" name="section_key" value="{{ old('section_key', $cta->section_key) }}"
                               class="form-control @error('section_key') is-invalid @enderror" required maxlength="60"
                               pattern="[a-z0-9_]+" title="Lowercase letters, numbers and underscores only"
                               {{ $cta->exists ? 'readonly' : '' }}>
                        @error('section_key')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $cta->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" maxlength="600" class="form-control">{{ old('description', $cta->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Extra Line 1 <span class="form-hint">e.g. address, subtitle</span></label>
                        <input type="text" name="extra_line1" value="{{ old('extra_line1', $cta->extra_line1) }}" maxlength="255" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Extra Line 2 <span class="form-hint">e.g. hours, tagline</span></label>
                        <input type="text" name="extra_line2" value="{{ old('extra_line2', $cta->extra_line2) }}" maxlength="255" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Background Image</label>
                        @if($cta->image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $cta->image_url }}" style="max-height:100px;border-radius:8px;"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $cta->button_text) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Button URL</label>
                            <input type="text" name="button_url" value="{{ old('button_url', $cta->button_url) }}" class="form-control">
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
                        <input type="number" name="sort_order" value="{{ old('sort_order', $cta->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cta->is_active ?? true) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $cta->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.cta.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
