@extends('layouts.admin')
@section('title', $tag->exists ? 'Edit Tag' : 'New Tag')
@section('page_title', $tag->exists ? 'Edit Blog Tag' : 'New Blog Tag')

@section('content')
<div style="max-width:600px;">
    <form method="POST"
          action="{{ $tag->exists ? route('admin.blog.tags.update', $tag) : route('admin.blog.tags.store') }}">
        @csrf
        @if($tag->exists) @method('PUT') @endif

        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Tag Details</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>Tag Name <span class="required">*</span></label>
                    <input type="text" name="name" id="tag-name" value="{{ old('name', $tag->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required maxlength="80">
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <div class="slug-wrap">
                        <span class="slug-prefix">/blog/tag/</span>
                        <input type="text" name="slug" id="tag-slug" value="{{ old('slug', $tag->slug) }}"
                               class="form-control @error('slug') is-invalid @enderror">
                    </div>
                    @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn btn-primary">{{ $tag->exists ? 'Update Tag' : 'Create Tag' }}</button>
                    <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const n = document.getElementById('tag-name'), s = document.getElementById('tag-slug');
let e = {{ $tag->exists ? 'true' : 'false' }};
s.addEventListener('input', () => e = true);
n.addEventListener('input', () => {
    if (e) return;
    s.value = n.value.toLowerCase().trim().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
});
</script>
@endpush
