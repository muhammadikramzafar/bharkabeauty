@extends('layouts.app')

@section('title', ($service->seo_title ?: $service->title) . ' — AmsazBeauty')
@if($service->seo_description)
@section('meta_description', $service->seo_description)
@endif
@if($service->seo_keywords)
@section('meta_keywords', $service->seo_keywords)
@endif

@push('styles')
<style>
/* ── Service Detail ─────────────────────────────────────── */
.service-banner { width:100%; max-height:420px; overflow:hidden; position:relative; background:#f9f5f0; }
.service-banner img { width:100%; height:420px; object-fit:cover; display:block; }
.service-banner-overlay { position:absolute; inset:0;
                           background:linear-gradient(to bottom, transparent 40%, rgba(26,26,46,.6)); }
.service-banner-title { position:absolute; bottom:0; left:0; right:0; padding:2rem;
                         color:#fff; font-size:2rem; font-weight:800; line-height:1.2;
                         text-shadow:0 2px 8px rgba(0,0,0,.4); }

.service-detail-layout { display:grid; grid-template-columns:1fr 340px; gap:2.5rem;
                          padding:2.5rem 0 4rem; align-items:start; }
@media(max-width:860px) {
    .service-detail-layout { grid-template-columns:1fr; }
}

.service-detail-main { }
.service-detail-main h1 { font-size:1.9rem; font-weight:800; color:#1a1a2e; margin:0 0 .75rem; }
.service-detail-meta { display:flex; gap:1rem; align-items:center; flex-wrap:wrap; margin-bottom:1.5rem; }
.service-meta-tag { display:inline-flex; align-items:center; gap:.4rem; padding:.35rem .85rem;
                     border-radius:999px; font-size:.82rem; font-weight:600; }
.service-meta-cat    { background:#f3e8d8; color:#92621a; }
.service-meta-price  { background:#e8f5e9; color:#2e7d32; }
.service-meta-dur    { background:#e3f2fd; color:#1565c0; }

.service-description { font-size:.97rem; line-height:1.8; color:#374151; }
.service-description h2, .service-description h3 { color:#1a1a2e; margin-top:1.5rem; }
.service-description ul, .service-description ol { padding-left:1.5rem; }
.service-description li { margin-bottom:.4rem; }
.service-description p { margin-bottom:1rem; }

.service-sidebar-card { background:#fff; border-radius:14px; padding:1.5rem;
                         box-shadow:0 2px 16px rgba(0,0,0,.07); position:sticky; top:90px; }
.service-sidebar-card h3 { font-size:1rem; font-weight:700; color:#1a1a2e; margin:0 0 1rem;
                            padding-bottom:.75rem; border-bottom:1px solid #f0e8da; }
.service-info-row { display:flex; justify-content:space-between; align-items:flex-start;
                    padding:.6rem 0; border-bottom:1px solid #f9f5f0; font-size:.875rem; }
.service-info-row:last-child { border-bottom:none; }
.service-info-label { color:#6b7280; font-weight:500; }
.service-info-value { color:#1a1a2e; font-weight:600; text-align:right; max-width:60%; }
.service-sidebar-cta { display:block; width:100%; text-align:center; padding:.85rem;
                        background:#c9a96e; color:#fff; border-radius:10px; font-weight:700;
                        font-size:.95rem; text-decoration:none; margin-top:1.25rem;
                        transition:background .2s; }
.service-sidebar-cta:hover { background:#b8956a; }
.service-sidebar-cta-outline { background:transparent; border:2px solid #1a1a2e; color:#1a1a2e;
                                 margin-top:.6rem; }
.service-sidebar-cta-outline:hover { background:#1a1a2e; color:#fff; }

/* ── Related Services ────────────────────────────────── */
.related-services { padding:3rem 0 4rem; background:#fdf8f4; }
.related-services h2 { font-size:1.5rem; font-weight:700; color:#1a1a2e; margin-bottom:1.5rem; }
.related-services-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:1.5rem; }

.related-card { background:#fff; border-radius:12px; overflow:hidden;
                box-shadow:0 2px 10px rgba(0,0,0,.06); transition:transform .2s; text-decoration:none; color:inherit; }
.related-card:hover { transform:translateY(-3px); }
.related-card__img { height:170px; overflow:hidden; background:#f9f5f0; }
.related-card__img img { width:100%; height:100%; object-fit:cover; }
.related-card__body { padding:1rem; }
.related-card__title { font-size:.92rem; font-weight:700; color:#1a1a2e; margin:0 0 .3rem; }
.related-card__price { font-size:.82rem; color:#c9a96e; font-weight:600; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('services.index') }}">Services</a></li>
                @if($service->category)
                    <li><a href="{{ route('services.index', ['category' => $service->category->slug]) }}">{{ $service->category->name }}</a></li>
                @endif
                <li aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Banner --}}
@if($service->banner_image_url)
<div class="service-banner">
    <img src="{{ $service->banner_image_url }}" alt="{{ $service->title }}">
    <div class="service-banner-overlay"></div>
    <div class="service-banner-title container">{{ $service->title }}</div>
</div>
@endif

{{-- Main Content --}}
<div class="container service-detail-layout">

    {{-- Left: Description --}}
    <div class="service-detail-main">

        @unless($service->banner_image_url)
        <h1>{{ $service->title }}</h1>
        @endunless

        <div class="service-detail-meta">
            @if($service->category)
                <span class="service-meta-tag service-meta-cat">{{ $service->category->name }}</span>
            @endif
            @if($service->price)
                <span class="service-meta-tag service-meta-price">{{ $service->price }}</span>
            @endif
            @if($service->duration)
                <span class="service-meta-tag service-meta-dur">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="13"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    {{ $service->duration }}
                </span>
            @endif
        </div>

        @if($service->excerpt)
            <p style="font-size:1.05rem;color:#4b5563;line-height:1.7;margin-bottom:1.5rem;font-style:italic;">
                {{ $service->excerpt }}
            </p>
        @endif

        @if($service->description)
            <div class="service-description">
                {!! $service->description !!}
            </div>
        @else
            <div style="padding:3rem;text-align:center;color:#9ca3af;background:#f9f5f0;border-radius:12px;">
                <p>Full service details coming soon.</p>
            </div>
        @endif

    </div>

    {{-- Right: Sidebar --}}
    <div>
        <div class="service-sidebar-card">
            <h3>Service Information</h3>

            @if($service->price)
            <div class="service-info-row">
                <span class="service-info-label">Price</span>
                <span class="service-info-value">{{ $service->price }}</span>
            </div>
            @endif

            @if($service->duration)
            <div class="service-info-row">
                <span class="service-info-label">Duration</span>
                <span class="service-info-value">{{ $service->duration }}</span>
            </div>
            @endif

            @if($service->category)
            <div class="service-info-row">
                <span class="service-info-label">Category</span>
                <span class="service-info-value">{{ $service->category->name }}</span>
            </div>
            @endif

            <div class="service-info-row">
                <span class="service-info-label">Availability</span>
                <span class="service-info-value" style="color:#16a34a;">Available Now</span>
            </div>

            <a href="{{ route('contact') }}" class="service-sidebar-cta">
                Book Appointment
            </a>
            <a href="{{ route('services.index') }}" class="service-sidebar-cta service-sidebar-cta-outline">
                View All Services
            </a>
        </div>
    </div>

</div>

{{-- Related Services --}}
@if($related->count() > 0)
<section class="related-services">
    <div class="container">
        <h2>
            @if($service->category)
                More {{ $service->category->name }} Services
            @else
                Related Services
            @endif
        </h2>
        <div class="related-services-grid">
            @foreach($related as $r)
            <a href="{{ route('services.show', $r->slug) }}" class="related-card">
                <div class="related-card__img">
                    @if($r->featured_image_url)
                        <img src="{{ $r->featured_image_url }}" alt="{{ $r->title }}" loading="lazy">
                    @elseif($r->banner_image_url)
                        <img src="{{ $r->banner_image_url }}" alt="{{ $r->title }}" loading="lazy">
                    @endif
                </div>
                <div class="related-card__body">
                    <p class="related-card__title">{{ $r->title }}</p>
                    @if($r->price)
                        <p class="related-card__price">{{ $r->price }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
