@extends('layouts.admin')
@section('title', $service->exists ? 'Edit Service' : 'New Service')
@section('page_title', $service->exists ? 'Edit Service Highlight' : 'Add Service Highlight')

@section('content')

<form method="POST"
      action="{{ $service->exists ? route('admin.homepage.services.update', $service) : route('admin.homepage.services.store') }}">
    @csrf
    @if($service->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-group">
                        <label>Icon Type</label>
                        <select name="icon_type" id="icon_type" class="form-control">
                            <option value="emoji" {{ old('icon_type', $service->icon_type ?? 'emoji') == 'emoji' ? 'selected' : '' }}>Emoji</option>
                            <option value="svg"   {{ old('icon_type', $service->icon_type ?? 'emoji') == 'svg'   ? 'selected' : '' }}>SVG Code</option>
                        </select>
                    </div>
                    <div class="form-group" id="icon-emoji-group">
                        <label>Emoji Icon</label>
                        <input type="text" name="icon" id="icon_input" value="{{ old('icon', $service->icon) }}" placeholder="✅ 🚚 💎 🔒" class="form-control" style="font-size:1.5rem;">
                        <small class="form-hint">Paste a single emoji or Unicode character</small>
                    </div>
                    <div class="form-group" id="icon-svg-group" style="display:none;">
                        <label>SVG Code</label>
                        <textarea name="icon_svg" rows="5" class="form-control" style="font-family:monospace;font-size:.82rem;" placeholder="<svg xmlns=...>...</svg>">{{ old('icon_svg', $service->icon_type === 'svg' ? $service->icon : '') }}</textarea>
                        <small class="form-hint">Paste complete inline SVG markup. Width/height will be overridden by CSS.</small>
                    </div>
                    <div class="form-group">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $service->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ old('description', $service->description) }}" maxlength="255" class="form-control">
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
                        <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $service->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.services.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
const iconType  = document.getElementById('icon_type');
const emojiGrp  = document.getElementById('icon-emoji-group');
const svgGrp    = document.getElementById('icon-svg-group');
const iconInput = document.getElementById('icon_input');

function toggleIcon() {
    const isSvg = iconType.value === 'svg';
    emojiGrp.style.display = isSvg ? 'none' : '';
    svgGrp.style.display   = isSvg ? '' : 'none';
    // mirror SVG textarea into hidden icon field
    document.querySelector('[name=icon_svg]').addEventListener('input', e => {
        iconInput.value = e.target.value;
    });
}
iconType.addEventListener('change', toggleIcon);
toggleIcon();

// Keep hidden icon field in sync
document.querySelector('[name=icon_svg]')?.addEventListener('input', e => {
    iconInput.value = e.target.value;
});
</script>
@endpush
