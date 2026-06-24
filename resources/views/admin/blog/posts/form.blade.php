@extends('layouts.admin')
@section('title', $post->exists ? 'Edit Post' : 'New Blog Post')
@section('page_title', $post->exists ? 'Edit Post' : 'New Blog Post')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
.ql-container { font-family: inherit; font-size: .95rem; }
.ql-editor    { min-height: 340px; }
.ql-toolbar   { border-top-left-radius: 8px; border-top-right-radius: 8px; background: #f9fafb; }
.ql-container { border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
#schedule-row { display: none; }
.tag-grid  { display: flex; flex-wrap: wrap; gap: .4rem; }
.tag-check { display: none; }
.tag-label { display: inline-block; padding: .3rem .75rem; border-radius: 999px; font-size: .8rem;
             font-weight: 600; border: 1.5px solid #e5e7eb; cursor: pointer; transition: all .15s;
             background: #fff; color: #4b5563; user-select: none; }
.tag-check:checked + .tag-label { background: #c9a96e; border-color: #c9a96e; color: #fff; }
</style>
@endpush

@section('content')

@if($errors->any())
<div class="alert" style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;border-radius:8px;padding:1rem;margin-bottom:1.25rem;">
    <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" id="post-form"
      action="{{ $post->exists ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($post->exists) @method('PUT') @endif

    <div class="page-editor-layout">

        {{-- ════ MAIN ════ --}}
        <div class="page-editor-main">

            {{-- Core --}}
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Post Title <span class="required">*</span></label>
                        <input type="text" name="title" id="post-title"
                               value="{{ old('title', $post->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required maxlength="220" placeholder="Enter post title…">
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/blog/</span>
                            <input type="text" name="slug" id="post-slug"
                                   value="{{ old('slug', $post->slug) }}"
                                   class="form-control @error('slug') is-invalid @enderror">
                        </div>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Excerpt <span class="form-hint">Short summary shown on listing cards</span></label>
                        <textarea name="excerpt" rows="2" maxlength="600"
                                  class="form-control" placeholder="Write a brief summary…">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Rich Text Content --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Content</h3></div>
                <div style="padding:1rem 1.25rem 1.25rem;">
                    <div id="quill-editor"></div>
                    {{-- Hidden field carries HTML to server --}}
                    <input type="hidden" name="content" id="content-input" value="{{ old('content', $post->content) }}">
                    @error('content')<span class="invalid-feedback" style="display:block;margin-top:.4rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Featured Image</h3></div>
                <div class="admin-form">
                    @if($post->featured_image_url)
                        <div style="margin-bottom:.75rem;">
                            <img src="{{ $post->featured_image_url }}" style="max-height:160px;border-radius:8px;object-fit:cover;max-width:100%;">
                        </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*"
                           class="form-control @error('featured_image') is-invalid @enderror"
                           id="featured-image-input">
                    <small class="form-hint">Recommended: 1200×630px (Open Graph). Max 5MB.</small>
                    @error('featured_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    {{-- Preview --}}
                    <div id="img-preview" style="margin-top:.75rem;display:none;">
                        <img id="img-preview-src" style="max-height:140px;border-radius:8px;">
                    </div>
                </div>
            </div>

            {{-- Tags --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Tags</h3>
                    <a href="{{ route('admin.blog.tags.create') }}" target="_blank"
                       style="font-size:.8rem;color:#c9a96e;">+ New tag</a>
                </div>
                <div style="padding:1rem 1.25rem 1.25rem;">
                    @if($tags->isEmpty())
                        <p style="color:#9ca3af;font-size:.85rem;">No tags yet. <a href="{{ route('admin.blog.tags.create') }}" style="color:#c9a96e;">Create some →</a></p>
                    @else
                        <div class="tag-grid">
                            @foreach($tags as $tag)
                                <div>
                                    <input type="checkbox" class="tag-check"
                                           id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
                                           {{ in_array($tag->id, old('tags', $postTags->toArray())) ? 'checked' : '' }}>
                                    <label for="tag-{{ $tag->id }}" class="tag-label">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">SEO</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" maxlength="160"
                               value="{{ old('seo_title', $post->seo_title) }}"
                               class="form-control" placeholder="Defaults to post title if left empty">
                    </div>
                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea name="seo_description" rows="3" maxlength="320"
                                  class="form-control" placeholder="120–160 characters">{{ old('seo_description', $post->seo_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>SEO Keywords</label>
                        <input type="text" name="seo_keywords" maxlength="255"
                               value="{{ old('seo_keywords', $post->seo_keywords) }}"
                               class="form-control" placeholder="beauty, skincare, makeup tips">
                    </div>
                </div>
            </div>

        </div>

        {{-- ════ SIDEBAR ════ --}}
        <div class="page-editor-sidebar">

            {{-- Publish --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Publish</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" id="post-status" class="form-control">
                            <option value="draft"     {{ old('status', $post->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>

                    <div id="schedule-row" class="form-group">
                        <label>Publish Date &amp; Time</label>
                        <input type="datetime-local" name="published_at" id="published-at"
                               value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                               class="form-control">
                        <small class="form-hint">Post goes live at this time automatically.</small>
                    </div>

                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                               value="{{ old('sort_order', $post->sort_order ?? 0) }}"
                               min="0" class="form-control">
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">
                            @if($post->exists)
                                Update Post
                            @else
                                <span id="publish-label">Save Draft</span>
                            @endif
                        </button>
                        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>

            {{-- Post Meta --}}
            <div class="admin-card" style="margin-top:1rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Post Details</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Author</label>
                        <select name="user_id" class="form-control">
                            @foreach($authors as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $post->user_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="blog_category_id" class="form-control">
                            <option value="">— Uncategorised —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('blog_category_id', $post->blog_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-hint">
                            <a href="{{ route('admin.blog.categories.create') }}" target="_blank" style="color:#c9a96e;">+ New category</a>
                        </small>
                    </div>
                </div>
            </div>

            @if($post->exists)
            <div class="admin-card" style="margin-top:1rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Danger Zone</h3></div>
                <div style="padding:1rem;">
                    <form method="POST" action="{{ route('admin.blog.posts.destroy', $post) }}"
                          onsubmit="return confirm('Permanently delete this post?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-full">Delete Post</button>
                    </form>
                </div>
            </div>
            @endif

        </div>

    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
// ── Quill Rich Text Editor ───────────────────────────────────
const quill = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'Write your post content here…',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, 4, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            [{ align: [] }],
            ['clean']
        ]
    }
});

// Load existing content
const existingContent = document.getElementById('content-input').value;
if (existingContent) quill.root.innerHTML = existingContent;

// Sync to hidden input before submit
document.getElementById('post-form').addEventListener('submit', function() {
    document.getElementById('content-input').value = quill.root.innerHTML;
});

// ── Slug auto-generation ──────────────────────────────────────
const titleInput = document.getElementById('post-title');
const slugInput  = document.getElementById('post-slug');
let slugEdited   = {{ $post->exists ? 'true' : 'false' }};

slugInput.addEventListener('input', () => slugEdited = true);
titleInput.addEventListener('input', () => {
    if (slugEdited) return;
    slugInput.value = titleInput.value
        .toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});

// ── Scheduled publishing toggle ───────────────────────────────
const statusSel   = document.getElementById('post-status');
const scheduleRow = document.getElementById('schedule-row');
const publishLabel= document.getElementById('publish-label');
const publishedAt = document.getElementById('published-at');

function updateStatusUI() {
    const v = statusSel.value;
    scheduleRow.style.display = v === 'scheduled' ? 'block' : 'none';
    if (publishLabel) {
        publishLabel.textContent = { published: 'Publish Now', scheduled: 'Schedule Post', draft: 'Save Draft' }[v] || 'Save';
    }
    if (v === 'scheduled' && !publishedAt.value) {
        // Default to 1 hour from now
        const d = new Date(Date.now() + 3600000);
        publishedAt.value = d.toISOString().slice(0, 16);
    }
}

statusSel.addEventListener('change', updateStatusUI);
updateStatusUI(); // run on load

// ── Featured image preview ────────────────────────────────────
document.getElementById('featured-image-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview-src').src = e.target.result;
        document.getElementById('img-preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
