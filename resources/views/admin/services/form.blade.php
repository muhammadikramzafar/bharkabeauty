@extends('layouts.admin')
@section('title', $service->exists ? 'Edit Service' : 'New Service')
@section('page_title', $service->exists ? 'Edit Service' : 'New Service')

@section('content')

<form method="POST"
      action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('PUT') @endif

    <div class="page-editor-layout">

        {{-- ========== MAIN ========== --}}
        <div class="page-editor-main">

            {{-- Basic Info --}}
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Service Details</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>Service Title <span class="required">*</span></label>
                        <input type="text" name="title" id="svc-title"
                               value="{{ old('title', $service->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required maxlength="200">
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Slug <span class="form-hint">URL-friendly identifier — auto-generated</span></label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/services/</span>
                            <input type="text" name="slug" id="svc-slug"
                                   value="{{ old('slug', $service->slug) }}"
                                   class="form-control @error('slug') is-invalid @enderror">
                        </div>
                        @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Excerpt <span class="form-hint">Short description shown on listing cards</span></label>
                        <textarea name="excerpt" rows="2" maxlength="500"
                                  class="form-control">{{ old('excerpt', $service->excerpt) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="description" id="svc-description" rows="10"
                                  class="form-control">{{ old('description', $service->description) }}</textarea>
                        <small class="form-hint">HTML is supported for rich formatting.</small>
                    </div>

                </div>
            </div>

            {{-- Images --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Images</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>Banner Image <span class="form-hint">Full-width top banner on detail page</span></label>
                        @if($service->banner_image_url)
                            <div style="margin-bottom:.75rem;">
                                <img src="{{ $service->banner_image_url }}"
                                     style="max-height:140px;border-radius:8px;object-fit:cover;max-width:100%;">
                            </div>
                        @endif
                        <input type="file" name="banner_image" accept="image/*"
                               class="form-control @error('banner_image') is-invalid @enderror">
                        <small class="form-hint">Recommended: 1400×500px, max 5MB</small>
                        @error('banner_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Featured Image <span class="form-hint">Card/thumbnail image on listing page</span></label>
                        @if($service->featured_image_url)
                            <div style="margin-bottom:.75rem;">
                                <img src="{{ $service->featured_image_url }}"
                                     style="max-height:110px;border-radius:8px;object-fit:cover;">
                            </div>
                        @endif
                        <input type="file" name="featured_image" accept="image/*"
                               class="form-control @error('featured_image') is-invalid @enderror">
                        <small class="form-hint">Recommended: 600×400px, max 3MB</small>
                        @error('featured_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>

            {{-- SEO --}}
            <div class="admin-card" style="margin-top:1.25rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">SEO</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title"
                               value="{{ old('seo_title', $service->seo_title) }}"
                               maxlength="160" class="form-control">
                        <small class="form-hint">Recommended: under 60 characters</small>
                    </div>

                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea name="seo_description" rows="3" maxlength="320"
                                  class="form-control">{{ old('seo_description', $service->seo_description) }}</textarea>
                        <small class="form-hint">Recommended: 120–160 characters</small>
                    </div>

                    <div class="form-group">
                        <label>SEO Keywords</label>
                        <input type="text" name="seo_keywords"
                               value="{{ old('seo_keywords', $service->seo_keywords) }}"
                               maxlength="255" class="form-control"
                               placeholder="beauty services, facial, makeup, spa">
                    </div>

                </div>
            </div>

        </div>

        {{-- ========== SIDEBAR ========== --}}
        <div class="page-editor-sidebar">

            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Publish</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" class="form-control">
                            <option value="published" {{ old('status', $service->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft"     {{ old('status', $service->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                               value="{{ old('sort_order', $service->sort_order ?? 0) }}"
                               min="0" class="form-control">
                        <small class="form-hint">Lower = appears first</small>
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">
                            {{ $service->exists ? 'Update Service' : 'Publish Service' }}
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>

            <div class="admin-card" style="margin-top:1rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Category &amp; Details</h3></div>
                <div class="admin-form">

                    <div class="form-group">
                        <label>Service Category</label>
                        <select name="service_category_id" class="form-control">
                            <option value="">— Uncategorised —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('service_category_id', $service->service_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-hint">
                            <a href="{{ route('admin.service-categories.create') }}" target="_blank" style="color:#c9a96e;">
                                + Add new category
                            </a>
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Price / Starting From</label>
                        <input type="text" name="price"
                               value="{{ old('price', $service->price) }}"
                               maxlength="100" class="form-control"
                               placeholder="e.g. Starting from PKR 2,500">
                    </div>

                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" name="duration"
                               value="{{ old('duration', $service->duration) }}"
                               maxlength="80" class="form-control"
                               placeholder="e.g. 60–90 minutes">
                    </div>

                </div>
            </div>

            @if($service->exists)
            <div class="admin-card" style="margin-top:1rem;">
                <div class="admin-card-header"><h3 class="admin-card-title">Danger Zone</h3></div>
                <div style="padding:1rem;">
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                          onsubmit="return confirm('Permanently delete this service?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-full">Delete Service</button>
                    </form>
                </div>
            </div>
            @endif

        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
const titleInput = document.getElementById('svc-title');
const slugInput  = document.getElementById('svc-slug');
let slugEdited   = {{ $service->exists ? 'true' : 'false' }};

slugInput.addEventListener('input', () => slugEdited = true);
titleInput.addEventListener('input', () => {
    if (slugEdited) return;
    slugInput.value = titleInput.value
        .toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
});
</script>
@endpush
