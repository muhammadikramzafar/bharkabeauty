@extends('layouts.admin')
@section('title', 'Hero Slides')
@section('page_title', 'Hero Slider')

@section('content')


<div class="admin-card-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.hero.create') }}" class="btn btn-primary btn-sm">+ Add Slide</a>
</div>

<div class="admin-card">
    @forelse($slides as $slide)
    <div class="hero-slide-row" style="display:flex;align-items:center;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid #f3f4f6;">
        <div style="width:80px;height:50px;border-radius:6px;overflow:hidden;flex-shrink:0;background:#f3f4f6;">
            @if($slide->image_url)
                <img src="{{ $slide->image_url }}" alt="" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:.7rem;">No image</div>
            @endif
        </div>
        <div style="flex:1;min-width:0;">
            <p style="font-weight:600;margin:0;font-size:.9rem;">{{ $slide->title }}@if($slide->title_highlight) <span style="color:#c9a96e;">{{ $slide->title_highlight }}</span>@endif</p>
            @if($slide->eyebrow)<p style="font-size:.78rem;color:#6b7280;margin:.1rem 0 0;">{{ $slide->eyebrow }}</p>@endif
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;flex-shrink:0;">
            <span class="status-badge {{ $slide->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $slide->is_active ? 'Active' : 'Draft' }}</span>
            <a href="{{ route('admin.homepage.hero.edit', $slide) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.hero.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div style="padding:3rem;text-align:center;color:#9ca3af;">
        No slides yet. <a href="{{ route('admin.homepage.hero.create') }}">Add the first slide &rarr;</a>
    </div>
    @endforelse
    @if($slides->hasPages())
        <div class="admin-pagination" style="padding:1rem 1.5rem;">{{ $slides->links() }}</div>
    @endif
</div>
@endsection
