@extends('layouts.app')

@section('title', ($activeCategory ? $activeCategory->name . ' Services' : 'Our Services') . ' — AmsazBeauty')
@section('meta_description', $activeCategory?->description ?? 'Explore our full range of professional beauty services at AmsazBeauty.')

@push('styles')
<style>
/* ── Services page ─────────────────────────────────────────── */
.services-hero { background:#fdf8f4; padding:3rem 0 2.5rem; text-align:center; }
.services-hero__title { font-size:2.2rem; font-weight:700; color:#1a1a2e; margin:0 0 .5rem; }
.services-hero__sub   { color:#6b7280; font-size:1rem; }

.services-category-tabs { background:#fff; border-bottom:1px solid #f0e8da; position:sticky; top:64px; z-index:20; }
.services-category-tabs .container { display:flex; gap:.5rem; overflow-x:auto; padding:.75rem 0; scrollbar-width:none; }
.services-category-tabs .container::-webkit-scrollbar { display:none; }
.cat-tab { display:inline-flex; align-items:center; gap:.4rem; padding:.45rem 1rem; border-radius:999px;
           font-size:.85rem; font-weight:500; color:#4b5563; border:1.5px solid #e5e7eb; background:#fff;
           white-space:nowrap; cursor:pointer; text-decoration:none; transition:all .2s; }
.cat-tab:hover, .cat-tab.active { background:#c9a96e; border-color:#c9a96e; color:#fff; }
.cat-tab .count { font-size:.75rem; opacity:.75; }

.services-section { padding:3rem 0 4rem; }
.services-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(300px,1fr)); gap:1.75rem; }

.service-card { background:#fff; border-radius:14px; overflow:hidden;
                box-shadow:0 2px 12px rgba(0,0,0,.06); transition:transform .25s, box-shadow .25s; }
.service-card:hover { transform:translateY(-4px); box-shadow:0 8px 28px rgba(0,0,0,.11); }

.service-card__image { position:relative; height:210px; overflow:hidden; background:#f9f5f0; }
.service-card__image img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.service-card:hover .service-card__image img { transform:scale(1.04); }
.service-card__image-placeholder { display:flex; align-items:center; justify-content:center; height:100%; }
.service-card__cat-badge { position:absolute; top:.75rem; left:.75rem; background:rgba(201,169,110,.92);
                            color:#fff; font-size:.72rem; font-weight:600; padding:.3rem .7rem;
                            border-radius:999px; letter-spacing:.03em; }

.service-card__body { padding:1.25rem; }
.service-card__title { font-size:1.05rem; font-weight:700; color:#1a1a2e; margin:0 0 .5rem;
                       line-height:1.35; }
.service-card__excerpt { font-size:.85rem; color:#6b7280; margin:0 0 1rem; line-height:1.55;
                          display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.service-card__meta { display:flex; gap:1rem; align-items:center; margin-bottom:1rem; }
.service-card__price    { font-size:.88rem; font-weight:600; color:#c9a96e; }
.service-card__duration { font-size:.8rem; color:#9ca3af; display:flex; align-items:center; gap:.3rem; }
.service-card__cta { display:block; width:100%; padding:.6rem; text-align:center; background:#1a1a2e;
                     color:#fff; border-radius:8px; font-size:.85rem; font-weight:600;
                     text-decoration:none; transition:background .2s; }
.service-card__cta:hover { background:#c9a96e; }

.services-empty { text-align:center; padding:4rem 1rem; }
.services-empty h3 { font-size:1.3rem; color:#1a1a2e; margin-bottom:.5rem; }
.services-empty p  { color:#6b7280; margin-bottom:1.5rem; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                @if($activeCategory)
                    <li><a href="{{ route('services.index') }}">Services</a></li>
                    <li aria-current="page">{{ $activeCategory->name }}</li>
                @else
                    <li aria-current="page">Services</li>
                @endif
            </ol>
        </nav>
    </div>
</div>

{{-- Hero --}}
<section class="services-hero">
    <div class="container">
        <h1 class="services-hero__title">
            {{ $activeCategory ? $activeCategory->name : 'Our Services' }}
        </h1>
        <p class="services-hero__sub">
            {{ $activeCategory?->description ?? 'Discover our professional beauty services — crafted for you.' }}
        </p>
    </div>
</section>

{{-- Category Filter Tabs --}}
@if($categories->count() > 0)
<div class="services-category-tabs">
    <div class="container">
        <a href="{{ route('services.index') }}"
           class="cat-tab {{ !$activeCategory ? 'active' : '' }}">
            All Services
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('services.index', ['category' => $cat->slug]) }}"
           class="cat-tab {{ $activeCategory?->slug === $cat->slug ? 'active' : '' }}">
            {{ $cat->name }}
            @if($cat->published_services_count > 0)
                <span class="count">({{ $cat->published_services_count }})</span>
            @endif
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- Services Grid --}}
<section class="services-section">
    <div class="container">

        @if($services->isEmpty())
            <div class="services-empty">
                <h3>No services found</h3>
                <p>We're adding new services soon. Check back shortly!</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-md">Back to Home</a>
            </div>
        @else
            <div class="services-grid">
                @foreach($services as $service)
                <article class="service-card">
                    <a href="{{ route('services.show', $service->slug) }}" class="service-card__image">
                        @if($service->featured_image_url)
                            <img src="{{ $service->featured_image_url }}" alt="{{ $service->title }}" loading="lazy">
                        @elseif($service->banner_image_url)
                            <img src="{{ $service->banner_image_url }}" alt="{{ $service->title }}" loading="lazy">
                        @else
                            <div class="service-card__image-placeholder">
                                <svg viewBox="0 0 80 80" fill="none" width="64" height="64">
                                    <circle cx="40" cy="40" r="38" fill="#f3e8d8"/>
                                    <path d="M40 22c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 20c-8.8 0-16 4-16 9v3h32v-3c0-5-7.2-9-16-9z" fill="#c9a96e"/>
                                </svg>
                            </div>
                        @endif
                        @if($service->category)
                            <span class="service-card__cat-badge">{{ $service->category->name }}</span>
                        @endif
                    </a>
                    <div class="service-card__body">
                        <h3 class="service-card__title">
                            <a href="{{ route('services.show', $service->slug) }}" style="color:inherit;text-decoration:none;">
                                {{ $service->title }}
                            </a>
                        </h3>
                        @if($service->excerpt)
                            <p class="service-card__excerpt">{{ $service->excerpt }}</p>
                        @endif
                        <div class="service-card__meta">
                            @if($service->price)
                                <span class="service-card__price">{{ $service->price }}</span>
                            @endif
                            @if($service->duration)
                                <span class="service-card__duration">
                                    <svg viewBox="0 0 20 20" fill="currentColor" width="13"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    {{ $service->duration }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('services.show', $service->slug) }}" class="service-card__cta">
                            Learn More
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            @if($services->hasPages())
                <div class="pagination-wrap" style="margin-top:2.5rem;">
                    {{ $services->links() }}
                </div>
            @endif
        @endif

    </div>
</section>

@endsection
