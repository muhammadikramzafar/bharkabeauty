@extends('layouts.admin')
@section('title', $testimonial->exists ? 'Edit Testimonial' : 'New Testimonial')
@section('page_title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')

<form method="POST"
      action="{{ $testimonial->exists ? route('admin.homepage.testimonials.update', $testimonial) : route('admin.homepage.testimonials.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($testimonial->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Reviewer</h3></div>
                <div class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name <span class="required">*</span></label>
                            <input type="text" name="reviewer_name" value="{{ old('reviewer_name', $testimonial->reviewer_name) }}" class="form-control @error('reviewer_name') is-invalid @enderror" required>
                            @error('reviewer_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="reviewer_location" value="{{ old('reviewer_location', $testimonial->reviewer_location) }}" placeholder="Lahore, Pakistan" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Rating <span class="required">*</span></label>
                        <select name="rating" class="form-control" style="max-width:120px;">
                            @for($i=5;$i>=1;$i--)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i != 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Review Text <span class="required">*</span></label>
                        <textarea name="review_text" rows="4" maxlength="600" class="form-control @error('review_text') is-invalid @enderror" required>{{ old('review_text', $testimonial->review_text) }}</textarea>
                        @error('review_text')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Reviewer Photo</label>
                        @if($testimonial->reviewer_image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $testimonial->reviewer_image_url }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;"></div>
                        @endif
                        <input type="file" name="reviewer_image" accept="image/*" class="form-control">
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Referenced Product <span class="form-hint">(optional)</span></h3></div>
                <div class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" name="product_brand" value="{{ old('product_brand', $testimonial->product_brand) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="product_name" value="{{ old('product_name', $testimonial->product_name) }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Product Image</label>
                        @if($testimonial->product_image_url)
                            <div style="margin-bottom:.5rem;"><img src="{{ $testimonial->product_image_url }}" style="max-height:80px;border-radius:6px;"></div>
                        @endif
                        <input type="file" name="product_image" accept="image/*" class="form-control">
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
                        <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $testimonial->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.testimonials.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
