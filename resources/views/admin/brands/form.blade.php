@extends('layouts.admin')
@section('title', isset($brand) ? 'Edit Brand' : 'Add Brand')
@section('page_title', isset($brand) ? 'Edit Brand' : 'Add Brand')
@section('content')

<form method="POST"
      action="{{ isset($brand) ? route('admin.brands.update',$brand) : route('admin.brands.store') }}"
      enctype="multipart/form-data">
    @csrf @if(isset($brand)) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Brand Details</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Brand Name <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" value="{{ old('name',$brand->name??'') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Huda Beauty" oninput="autoSlug(this.value)">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug',$brand->slug??'') }}"
                               class="form-control" placeholder="auto-generated">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description',$brand->description??'') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Website URL</label>
                        <input type="url" name="website" value="{{ old('website',$brand->website??'') }}"
                               class="form-control" placeholder="https://www.brand.com">
                    </div>
                    <div class="form-group">
                        <label>Brand Logo</label>
                        @if(isset($brand) && $brand->logo_url)
                            <div class="image-preview-wrap"><img src="{{ $brand->logo_url }}" style="max-height:80px;"></div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="form-control" style="margin-top:.5rem;">
                        <small class="form-hint">Recommended: transparent PNG, 400×200px.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Settings</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active',$brand->is_active??true)?'selected':'' }}>Active</option>
                            <option value="0" {{ !old('is_active',$brand->is_active??true)?'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                            <input type="checkbox" name="is_featured" value="1"
                                   {{ old('is_featured',$brand->is_featured??false)?'checked':'' }}
                                   style="width:16px;height:16px;accent-color:#c9a96e;">
                            Show as Featured Brand
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" min="0"
                               value="{{ old('sort_order',$brand->sort_order??0) }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">{{ isset($brand)?'Update':'Create' }} Brand</button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline btn-full" style="margin-top:.5rem;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('scripts')
<script>
function autoSlug(v){const s=document.getElementById('slug');if(!s.dataset.edited)s.value=v.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');}
document.getElementById('slug').addEventListener('input',function(){this.dataset.edited='1';});
</script>
@endpush
