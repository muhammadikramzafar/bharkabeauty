@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')
@section('page_title', isset($category) ? 'Edit Category' : 'Add Category')
@section('content')

<form method="POST"
      action="{{ isset($category) ? route('admin.categories.update',$category) : route('admin.categories.store') }}"
      enctype="multipart/form-data">
    @csrf @if(isset($category)) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Category Details</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Category Name <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" value="{{ old('name',$category->name??'') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Skincare" oninput="autoSlug(this.value)">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug',$category->slug??'') }}"
                               class="form-control" placeholder="auto-generated">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="form-control"
                                  placeholder="Short description…">{{ old('description',$category->description??'') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Category Image</label>
                        @if(isset($category) && $category->image_url)
                            <div class="image-preview-wrap"><img src="{{ $category->image_url }}"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control" style="margin-top:.5rem;">
                    </div>
                </div>
            </div>
        </div>

        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Settings</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" class="form-control">
                            <option value="">— Root Category —</option>
                            @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ old('parent_id',$category->parent_id??'')==$p->id?'selected':'' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" min="0"
                               value="{{ old('sort_order',$category->sort_order??0) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active',$category->is_active??true)?'selected':'' }}>Active</option>
                            <option value="0" {{ !old('is_active',$category->is_active??true)?'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">{{ isset($category)?'Update':'Create' }} Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-full" style="margin-top:.5rem;">Cancel</a>
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
