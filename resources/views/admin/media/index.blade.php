@extends('layouts.admin')
@section('title', 'Media Library')
@section('page_title', 'Media Library')

@section('content')

{{-- Upload Zone --}}
<div class="admin-card">
    <div class="admin-card-header"><h3 class="admin-card-title">Upload Files</h3></div>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="media-upload-zone" id="drop-zone">
            <div class="media-upload-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="48"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            </div>
            <p class="media-upload-text">Drag & drop files here, or <label for="file-input" class="media-upload-browse">browse</label></p>
            <p class="media-upload-hint">Images (JPG, PNG, WebP, SVG) · PDFs · Videos (MP4) · Max 50 MB each</p>
            <input type="file" id="file-input" name="files[]" multiple accept="image/*,video/*,.pdf,.doc,.docx" class="sr-only">
        </div>
        <div id="file-preview-list" class="media-file-preview-list"></div>
        <div class="admin-form-actions" id="upload-actions" style="display:none;">
            <button type="submit" class="btn btn-primary">Upload Files</button>
            <button type="button" id="clear-files-btn" class="btn btn-outline">Clear</button>
        </div>
    </form>
</div>

{{-- Filters --}}
<div class="admin-card">
    <form method="GET" action="{{ route('admin.media.index') }}" class="media-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..." class="form-control media-search">
        <select name="type" class="form-control media-type-filter">
            <option value="">All Types</option>
            @foreach(['image','video','pdf','document'] as $t)
                <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}s</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request()->hasAny(['search','type']))
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline">Clear</a>
        @endif
    </form>
</div>

{{-- Grid --}}
<div class="admin-card">
    <div class="media-grid">
        @forelse($media as $file)
        <div class="media-card" data-id="{{ $file->id }}">
            <div class="media-card-thumb">
                @if($file->isImage())
                    <img src="{{ $file->url }}" alt="{{ $file->alt_text ?? $file->name }}" loading="lazy">
                @elseif($file->type === 'video')
                    <div class="media-thumb-icon media-thumb-video">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </div>
                @elseif($file->type === 'pdf')
                    <div class="media-thumb-icon media-thumb-pdf">PDF</div>
                @else
                    <div class="media-thumb-icon media-thumb-doc">DOC</div>
                @endif
                <div class="media-card-overlay">
                    <a href="{{ $file->url }}" target="_blank" class="media-overlay-btn" title="View">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <button class="media-overlay-btn media-copy-btn" data-url="{{ $file->url }}" title="Copy URL">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.media.destroy', $file) }}" onsubmit="return confirm('Delete this file?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="media-overlay-btn media-delete-btn" title="Delete">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="media-card-info">
                <p class="media-card-name" title="{{ $file->name }}">{{ Str::limit($file->name, 22) }}</p>
                <p class="media-card-meta">{{ strtoupper($file->type) }} · {{ $file->human_size }}</p>
            </div>
        </div>
        @empty
        <div class="media-empty">No files uploaded yet.</div>
        @endforelse
    </div>

    @if($media->hasPages())
        <div class="admin-pagination">{{ $media->links() }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
// Drop zone
const dropZone  = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const previewList = document.getElementById('file-preview-list');
const uploadActions = document.getElementById('upload-actions');

['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('dragover'); }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('dragover'); }));
dropZone.addEventListener('drop', ev => handleFiles(ev.dataTransfer.files));
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

function handleFiles(files) {
    previewList.innerHTML = '';
    if (!files.length) return;
    uploadActions.style.display = 'flex';
    Array.from(files).forEach(file => {
        const div = document.createElement('div');
        div.className = 'media-file-preview-item';
        div.innerHTML = `<span class="media-preview-name">${file.name}</span><span class="media-preview-size">${(file.size/1024).toFixed(1)} KB</span>`;
        previewList.appendChild(div);
    });
}

document.getElementById('clear-files-btn')?.addEventListener('click', () => {
    fileInput.value = '';
    previewList.innerHTML = '';
    uploadActions.style.display = 'none';
});

// Copy URL
document.querySelectorAll('.media-copy-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        navigator.clipboard.writeText(btn.dataset.url);
        btn.title = 'Copied!';
        setTimeout(() => btn.title = 'Copy URL', 2000);
    });
});
</script>
@endpush
