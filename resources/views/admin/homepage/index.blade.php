@extends('layouts.admin')
@section('title', 'Homepage Management')
@section('page_title', 'Homepage Management')

@section('content')

<div class="homepage-mgmt-grid">

    {{-- Settings & SEO --}}
    <a href="{{ route('admin.homepage.settings') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-settings">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Settings &amp; SEO</h3>
            <p>Flash sale, about section, CTAs, section toggles, SEO meta</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Hero Slider --}}
    <a href="{{ route('admin.homepage.hero.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-hero">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M8 5v14m8-14v14"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Hero Slider</h3>
            <p>{{ $counts['hero'] }} active slide{{ $counts['hero'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Banners --}}
    <a href="{{ route('admin.homepage.banners.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-banner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="7" width="18" height="10" rx="2"/><path d="M3 10h18"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Homepage Banners</h3>
            <p>{{ $counts['banners'] }} active banner{{ $counts['banners'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Client Logos --}}
    <a href="{{ route('admin.homepage.logos.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-logos">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Client Logos</h3>
            <p>{{ $counts['logos'] }} active brand{{ $counts['logos'] != 1 ? 's' : '' }} displayed</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Featured Projects --}}
    <a href="{{ route('admin.homepage.featured.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-featured">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="12" rx="2"/><path d="M3 20h18M8 20V15m8 5V15"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Featured Projects</h3>
            <p>{{ $counts['featured'] }} active featured collection{{ $counts['featured'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Service Highlights --}}
    <a href="{{ route('admin.homepage.services.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-services">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Service Highlights</h3>
            <p>{{ $counts['services'] }} active service{{ $counts['services'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Counters --}}
    <a href="{{ route('admin.homepage.counters.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-counters">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Counters</h3>
            <p>{{ $counts['counters'] }} active stat{{ $counts['counters'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- Testimonials --}}
    <a href="{{ route('admin.homepage.testimonials.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-testimonials">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Testimonials</h3>
            <p>{{ $counts['testimonials'] }} active review{{ $counts['testimonials'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    {{-- CTA Sections --}}
    <a href="{{ route('admin.homepage.cta.index') }}" class="homepage-section-card">
        <div class="homepage-section-icon hp-icon-cta">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 10l-4 4-4-4m4 4V3m8 14h-5l-4 4-4-4H3"/></svg>
        </div>
        <div class="homepage-section-info">
            <h3>Call To Action</h3>
            <p>{{ $counts['ctas'] }} active CTA section{{ $counts['ctas'] != 1 ? 's' : '' }}</p>
        </div>
        <svg class="homepage-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

</div>

<div class="admin-card" style="margin-top:1.5rem;">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Quick Links</h3>
    </div>
    <div style="padding:1rem 1.5rem; display:flex; gap:1rem; flex-wrap:wrap;">
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm">View Homepage &rarr;</a>
        <a href="{{ route('admin.homepage.settings') }}" class="btn btn-primary btn-sm">Edit Settings</a>
    </div>
</div>

@endsection

@push('styles')
<style>
.homepage-mgmt-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}
.homepage-section-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: border-color .2s, box-shadow .2s;
}
.homepage-section-card:hover {
    border-color: #c9a96e;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
}
.homepage-section-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.homepage-section-icon svg { width: 24px; height: 24px; }
.hp-icon-settings    { background: #fef3c7; color: #d97706; }
.hp-icon-hero        { background: #dbeafe; color: #2563eb; }
.hp-icon-banner      { background: #fce7f3; color: #db2777; }
.hp-icon-logos       { background: #d1fae5; color: #059669; }
.hp-icon-featured    { background: #ede9fe; color: #7c3aed; }
.hp-icon-services    { background: #ecfdf5; color: #10b981; }
.hp-icon-counters    { background: #fff7ed; color: #ea580c; }
.hp-icon-testimonials{ background: #f0fdf4; color: #16a34a; }
.hp-icon-cta         { background: #eff6ff; color: #3b82f6; }
.homepage-section-info { flex: 1; }
.homepage-section-info h3 { font-size: .95rem; font-weight: 600; margin: 0 0 .2rem; }
.homepage-section-info p  { font-size: .82rem; color: #6b7280; margin: 0; }
.homepage-section-arrow { width: 18px; height: 18px; color: #9ca3af; flex-shrink: 0; }
</style>
@endpush
