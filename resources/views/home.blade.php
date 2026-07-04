@extends('layouts.app')

@section('title', $setting->seo_title ?? 'BharkaBeauty — Premium Luxury Cosmetics & Skincare Pakistan')
@section('meta_description', $setting->seo_description ?? '')
@section('meta_keywords', $setting->seo_keywords ?? '')

@section('content')

    {{-- ─── HERO SLIDER ──────────────────────────────────────────── --}}
    @if($setting->show_hero)
    <section class="hero" aria-label="Hero banner" id="hero-section">

        @if($heroSlides->isNotEmpty())
            @foreach($heroSlides as $i => $slide)
            @if($slide->image_url)
            <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}"
                 loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center top;opacity:{{ $i === 0 ? '1' : '0' }};transition:opacity .6s ease;"
                 class="hero-bg-img" data-slide="{{ $i }}">
            @endif
            @endforeach

            @php $first = $heroSlides->first(); @endphp
            <div class="hero-content">
                @if($first->eyebrow)<p class="hero-eyebrow">{{ $first->eyebrow }}</p>@endif
                <h1 class="hero-title">{{ $first->title }}@if($first->title_highlight)<br><span>{{ $first->title_highlight }}</span>@endif</h1>
                @if($first->description)<p class="hero-desc">{{ $first->description }}</p>@endif
                @if($first->button1_text || $first->button2_text)
                <div class="hero-actions">
                    @if($first->button1_text)<a href="{{ $first->button1_url ?? '#' }}" class="btn btn-primary btn-lg">{{ $first->button1_text }}</a>@endif
                    @if($first->button2_text)<a href="{{ $first->button2_url ?? '#' }}" class="btn btn-outline btn-lg">{{ $first->button2_text }}</a>@endif
                </div>
                @endif
            </div>
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-visual-circle"></div>
                <div class="hero-product-mockup">
                    <div class="hero-product-circle">{{ $first->badge_text ?? 'Premium Beauty Collections' }}</div>
                </div>
            </div>
            @if($heroSlides->count() > 1)
            <div class="hero-dots" role="tablist" aria-label="Hero slides">
                @foreach($heroSlides as $i => $slide)
                <button class="hero-dot {{ $i === 0 ? 'active' : '' }}" role="tab" aria-label="Slide {{ $i + 1 }}" data-dot="{{ $i }}"></button>
                @endforeach
            </div>
            @endif

        @else
        {{-- Static fallback --}}
        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1440&h=720&fit=crop" alt="BharkaBeauty" loading="eager" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center top;">
        <div class="hero-content">
            <p class="hero-eyebrow">New Season, New Glow</p>
            <h1 class="hero-title">Your Beauty,<br><span>Our Craft</span></h1>
            <p class="hero-desc">Pakistan's most curated luxury beauty destination — premium cosmetics, skincare rituals, and expert-approved picks delivered to your door.</p>
            <div class="hero-actions">
                <a href="{{ route('category.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
                <a href="{{ route('brands') }}" class="btn btn-outline btn-lg">Explore Brands</a>
            </div>
        </div>
        <div class="hero-visual" aria-hidden="true">
            <div class="hero-visual-circle"></div>
            <div class="hero-product-mockup">
                <div class="hero-product-circle">Premium<br>Beauty<br>Collections</div>
            </div>
        </div>
        <div class="hero-dots" role="tablist" aria-label="Hero slides">
            <button class="hero-dot active" aria-label="Slide 1"></button>
            <button class="hero-dot" aria-label="Slide 2"></button>
            <button class="hero-dot" aria-label="Slide 3"></button>
        </div>
        @endif
    </section>
    @endif

    {{-- ─── TOP BANNER ──────────────────────────────────────────── --}}
    @foreach($banners->where('position', 'top') as $banner)
    <div class="homepage-promo-banner" style="background:linear-gradient(135deg,#1a1a2e,#2d1b69);padding:2rem;text-align:center;color:#fff;position:relative;overflow:hidden;">
        @if($banner->image_url)<img src="{{ $banner->image_url }}" alt="" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.25;">@endif
        <div style="position:relative;z-index:1;">
            @if($banner->badge_text)<span style="display:inline-block;background:#c9a96e;color:#000;font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.25rem .75rem;border-radius:20px;margin-bottom:.75rem;">{{ $banner->badge_text }}</span>@endif
            <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 .5rem;">{{ $banner->title }}</h2>
            @if($banner->subtitle)<p style="margin:.25rem 0 1rem;opacity:.85;">{{ $banner->subtitle }}</p>@endif
            @if($banner->button_text)<a href="{{ $banner->button_url ?? '#' }}" class="btn btn-primary btn-md">{{ $banner->button_text }}</a>@endif
        </div>
    </div>
    @endforeach

    {{-- ─── SHOP BY CATEGORY ─────────────────────────────────────── --}}
    @if($setting->show_categories)
    <section class="section categories-section" aria-labelledby="categories-heading">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" id="categories-heading">Shop by Category</h2>
                <p class="section-subtitle">Explore our curated beauty departments</p>
            </div>
            <div class="categories-grid" role="list">
                @forelse($rootCategories as $cat)
                <a href="{{ route('category.index', ['cat' => $cat->slug]) }}" class="category-item" role="listitem">
                    @if($cat->image_url)
                        <div class="category-icon-wrap" style="background-image:url('{{ $cat->image_url }}');background-size:cover;background-position:center;border-radius:50%;overflow:hidden;">
                        </div>
                    @else
                        <div class="category-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="32" height="32"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </div>
                    @endif
                    <span class="category-name">{{ $cat->name }}</span>
                    @if($cat->products_count > 0)
                    <span style="font-size:.72rem;color:#9ca3af;">{{ $cat->products_count }} products</span>
                    @endif
                </a>
                @empty
                <p style="color:#9ca3af;grid-column:1/-1;text-align:center;padding:2rem;">No categories yet.</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- ─── SERVICE HIGHLIGHTS ───────────────────────────────────── --}}
    @if($setting->show_services && $services->isNotEmpty())
    <section class="section services-highlight-section" aria-label="Why shop with us">
        <div class="container">
            <div class="services-highlight-grid">
                @foreach($services as $service)
                <div class="service-highlight-item">
                    <div class="service-highlight-icon">
                        @if($service->icon_type === 'emoji' && $service->icon)
                            <span>{{ $service->icon }}</span>
                        @elseif($service->icon)
                            {!! $service->icon !!}
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="32" height="32"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="service-highlight-title">{{ $service->title }}</h3>
                        @if($service->description)<p class="service-highlight-desc">{{ $service->description }}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── FEATURED PRODUCTS ───────────────────────────────────────── --}}
    @if($featuredProducts->isNotEmpty())
    <section class="section flash-sale-section" aria-labelledby="featured-heading">
        <div class="container">
            <div class="flash-sale-header">
                <div class="flash-sale-left">
                    <h2 class="section-title" id="featured-heading">Featured Products</h2>
                    <p class="section-subtitle">Our editors' top picks — handpicked just for you</p>
                </div>
                <a href="{{ route('category.index') }}" class="link-arrow" style="white-space:nowrap;">View All &rarr;</a>
            </div>
            <div class="products-grid" role="list">
                @foreach($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── SALE / FLASH SALE ────────────────────────────────────────── --}}
    @if($saleProducts->isNotEmpty() && $setting->show_flash_sale)
    <section class="section flash-sale-section" style="background:#fdf6ee;" aria-labelledby="flash-sale-heading">
        <div class="container">
            <div class="flash-sale-header">
                <div class="flash-sale-left">
                    <h2 class="section-title" id="flash-sale-heading">{{ $setting->flash_sale_title ?: 'On Sale Now' }}</h2>
                    <p class="section-subtitle">{{ $setting->flash_sale_subtitle ?: 'Limited-time deals on premium beauty — don\'t miss out.' }}</p>
                </div>
                @if($setting->flash_sale_end)
                <div class="countdown" aria-label="Time remaining" data-end="{{ $setting->flash_sale_end->toIso8601String() }}">
                    <div class="countdown-item"><span class="countdown-number" id="countdown-hh">00</span><span class="countdown-label">HH</span></div>
                    <span class="countdown-sep" aria-hidden="true">:</span>
                    <div class="countdown-item"><span class="countdown-number" id="countdown-mm">00</span><span class="countdown-label">MM</span></div>
                    <span class="countdown-sep" aria-hidden="true">:</span>
                    <div class="countdown-item"><span class="countdown-number" id="countdown-ss">00</span><span class="countdown-label">SS</span></div>
                </div>
                @endif
            </div>
            <div class="products-grid" role="list">
                @foreach($saleProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── NEW ARRIVALS ─────────────────────────────────────────────── --}}
    @if($newArrivals->isNotEmpty())
    <section class="section flash-sale-section" aria-labelledby="new-arrivals-heading">
        <div class="container">
            <div class="flash-sale-header">
                <div class="flash-sale-left">
                    <h2 class="section-title" id="new-arrivals-heading">New Arrivals</h2>
                    <p class="section-subtitle">Fresh drops — be the first to explore our latest additions</p>
                </div>
                <a href="{{ route('category.index', ['sort' => 'newest']) }}" class="link-arrow" style="white-space:nowrap;">View All &rarr;</a>
            </div>
            <div class="products-grid" role="list">
                @foreach($newArrivals as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── MIDDLE BANNER ────────────────────────────────────────── --}}
    @foreach($banners->where('position', 'middle') as $banner)
    <div class="homepage-promo-banner" style="background:linear-gradient(135deg,#c9a96e,#9a7b4f);padding:2rem;text-align:center;color:#fff;position:relative;overflow:hidden;">
        @if($banner->image_url)<img src="{{ $banner->image_url }}" alt="" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.3;">@endif
        <div style="position:relative;z-index:1;">
            @if($banner->badge_text)<span style="display:inline-block;background:rgba(255,255,255,.2);backdrop-filter:blur(4px);font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.25rem .75rem;border-radius:20px;margin-bottom:.75rem;">{{ $banner->badge_text }}</span>@endif
            <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 .5rem;">{{ $banner->title }}</h2>
            @if($banner->subtitle)<p style="margin:.25rem 0 1rem;opacity:.9;">{{ $banner->subtitle }}</p>@endif
            @if($banner->button_text)<a href="{{ $banner->button_url ?? '#' }}" class="btn btn-dark btn-md">{{ $banner->button_text }}</a>@endif
        </div>
    </div>
    @endforeach

    {{-- ─── CLIENT LOGOS / SHOP BY BRAND ────────────────────────── --}}
    @if($setting->show_brands)
    <section class="section brands-section" aria-labelledby="brands-heading">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" id="brands-heading">Shop by Brand</h2>
                <p class="section-subtitle">Explore our curated selection of premium beauty brands</p>
            </div>
            <div class="brands-grid">
                @if($logos->isNotEmpty())
                    @foreach($logos as $logo)
                    <a href="{{ $logo->url ?? route('brands') }}" class="brand-card">
                        @if($logo->logo_url)<img src="{{ $logo->logo_url }}" alt="{{ $logo->name }}" style="max-height:40px;object-fit:contain;margin-bottom:.4rem;">@endif
                        <p class="brand-name">{{ $logo->name }}</p>
                        @if($logo->tagline)<p class="brand-cat">{{ $logo->tagline }}</p>@endif
                    </a>
                    @endforeach
                @elseif($featuredBrands->isNotEmpty())
                    @foreach($featuredBrands as $brand)
                    <a href="{{ route('category.index', ['brand' => $brand->slug]) }}" class="brand-card">
                        @if($brand->logo_url)
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" style="max-height:56px;max-width:120px;object-fit:contain;margin-bottom:.4rem;">
                        @else
                            <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#c9a96e,#a07840);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1rem;margin:0 auto .4rem;">{{ strtoupper(substr($brand->name,0,1)) }}</div>
                        @endif
                        <p class="brand-name">{{ $brand->name }}</p>
                        <p class="brand-cat">{{ $brand->products_count }} products</p>
                    </a>
                    @endforeach
                @endif
            </div>
            <div class="brands-viewall">
                <a href="{{ route('brands') }}" class="link-arrow">View All Brands &rarr;</a>
            </div>
        </div>
    </section>
    @endif

    {{-- ─── FEATURED COLLECTIONS ─────────────────────────────────── --}}
    @if($setting->show_featured)
    <section class="section collections-section" aria-labelledby="collections-heading">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" id="collections-heading">Curated For You</h2>
                <p class="section-subtitle">Discover our most loved collections, thoughtfully selected for you</p>
            </div>
            <div class="collections-list">
                @if($featured->isNotEmpty())
                    @foreach($featured as $item)
                    <div class="collection-row">
                        <div class="collection-content">
                            @if($item->eyebrow)<p class="collection-eyebrow">{{ $item->eyebrow }}</p>@endif
                            <h3 class="collection-title">{{ $item->title }}</h3>
                            @if($item->description)<p class="collection-desc">{{ $item->description }}</p>@endif
                            @if($item->button_text)<a href="{{ $item->button_url ?? '#' }}" class="btn btn-dark btn-md" style="align-self:flex-start;">{{ $item->button_text }}</a>@endif
                        </div>
                        <div class="collection-image" style="{{ $item->image_url ? 'background-image:url('.$item->image_url.');' : '' }}background-size:cover;background-position:center;">
                            <div class="collection-image-placeholder" style="background:rgba(0,0,0,0.35);">{{ $item->title }}</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="collection-row">
                        <div class="collection-content"><p class="collection-eyebrow">Collection</p><h3 class="collection-title">Best Sellers</h3><p class="collection-desc">Our most-loved products, tried and tested by thousands of beauty lovers across Pakistan.</p><a href="{{ route('category.index', ['col' => 'bestsellers']) }}" class="btn btn-dark btn-md" style="align-self:flex-start;">Shop Best Sellers</a></div>
                        <div class="collection-image" style="background-image:url('https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=624&h=240&fit=crop');background-size:cover;background-position:center;"><div class="collection-image-placeholder" style="background:rgba(0,0,0,0.35);">Best Sellers</div></div>
                    </div>
                    <div class="collection-row">
                        <div class="collection-content"><p class="collection-eyebrow">New In</p><h3 class="collection-title">New Arrivals</h3><p class="collection-desc">Fresh drops of the latest skincare, makeup and more — be the first to explore.</p><a href="{{ route('category.index', ['col' => 'new']) }}" class="btn btn-dark btn-md" style="align-self:flex-start;">Shop New Arrivals</a></div>
                        <div class="collection-image new-arrivals" style="background-image:url('https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=624&h=240&fit=crop');background-size:cover;background-position:center;"><div class="collection-image-placeholder" style="background:rgba(0,0,0,0.35);">New Arrivals</div></div>
                    </div>
                    <div class="collection-row">
                        <div class="collection-content"><p class="collection-eyebrow">Trending</p><h3 class="collection-title">Trending Now</h3><p class="collection-desc">What beauty lovers are obsessing over right now — get on trend before it sells out.</p><a href="{{ route('category.index', ['col' => 'trending']) }}" class="btn btn-dark btn-md" style="align-self:flex-start;">Shop Trending</a></div>
                        <div class="collection-image trending" style="background-image:url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=624&h=240&fit=crop');background-size:cover;background-position:center;"><div class="collection-image-placeholder" style="background:rgba(0,0,0,0.35);">Trending</div></div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ─── ABOUT SECTION ────────────────────────────────────────── --}}
    @if($setting->show_about && $setting->about_title)
    <section class="section about-section" aria-labelledby="about-heading">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">
                <div>
                    @if($setting->about_eyebrow)<p style="text-transform:uppercase;letter-spacing:.1em;font-size:.78rem;color:#c9a96e;font-weight:600;margin-bottom:.5rem;">{{ $setting->about_eyebrow }}</p>@endif
                    <h2 class="section-title" id="about-heading" style="margin-bottom:1rem;">{{ $setting->about_title }}</h2>
                    @if($setting->about_description)<p style="color:#555;line-height:1.8;margin-bottom:1.5rem;">{{ $setting->about_description }}</p>@endif
                    @if($setting->about_button_text)<a href="{{ $setting->about_button_url ?? route('about') }}" class="btn btn-primary btn-md">{{ $setting->about_button_text }}</a>@endif
                </div>
                @if($setting->about_image)
                <div>
                    <img src="{{ Storage::disk('public')->url($setting->about_image) }}" alt="{{ $setting->about_title }}" loading="lazy" style="width:100%;border-radius:16px;object-fit:cover;">
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ─── STATS COUNTERS ───────────────────────────────────────── --}}
    @if($setting->show_counters && $counters->isNotEmpty())
    <section class="section counters-section" aria-label="Stats">
        <div class="container">
            <div class="counters-grid">
                @foreach($counters as $counter)
                <div class="counter-item">
                    <span class="counter-number">{{ $counter->number }}{{ $counter->suffix }}</span>
                    <span class="counter-label">{{ $counter->label }}</span>
                    @if($counter->description)<span class="counter-desc">{{ $counter->description }}</span>@endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── TESTIMONIALS ──────────────────────────────────────────── --}}
    @if($setting->show_testimonials && $testimonials->isNotEmpty())
    <section class="section reviews-section" aria-labelledby="reviews-heading">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" id="reviews-heading">What Our Customers Say</h2>
                <p class="section-subtitle">Real reviews from real beauty lovers across Pakistan</p>
            </div>
            <div class="reviews-grid">
                @foreach($testimonials as $t)
                <article class="review-card">
                    <div class="review-stars" aria-label="{{ $t->rating }} out of 5">
                        @for($i=1;$i<=5;$i++)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:16px;height:16px;fill:{{ $i<=$t->rating ? '#f59e0b' : '#e5e7eb' }};display:inline-block;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor
                    </div>
                    <blockquote class="review-text">&ldquo;{{ $t->review_text }}&rdquo;</blockquote>
                    <div class="review-author">
                        @if($t->reviewer_image_url)
                            <img src="{{ $t->reviewer_image_url }}" alt="{{ $t->reviewer_name }}" class="review-author-img" loading="lazy">
                        @else
                            <div class="review-author-initial" aria-hidden="true">{{ strtoupper(substr($t->reviewer_name,0,1)) }}</div>
                        @endif
                        <div class="review-author-info">
                            <p class="review-author-name">{{ $t->reviewer_name }}</p>
                            @if($t->reviewer_location)<p class="review-author-location">{{ $t->reviewer_location }}</p>@endif
                        </div>
                        @if($t->product_brand)
                        <div class="review-product-ref" style="margin-left:auto;text-align:right;">
                            <p class="review-product-brand" style="font-size:.75rem;color:#9ca3af;margin:0;">{{ $t->product_brand }}</p>
                            @if($t->product_name)<p class="review-product-name" style="font-size:.78rem;font-weight:600;margin:0;color:#374151;">{{ $t->product_name }}</p>@endif
                        </div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── FLAGSHIP STORE CTA ────────────────────────────────────── --}}
    @if($setting->show_store_cta)
    @php $storeCta = $ctas['flagship_store'] ?? null; @endphp
    <section class="store-section" aria-labelledby="store-heading">
        <div class="store-inner">
            <div class="store-content">
                <h2 class="store-title" id="store-heading">
                    {{ $storeCta ? $storeCta->title : ($setting->store_title ?: 'Visit Our Flagship Store') }}
                </h2>
                <p class="store-desc">
                    {{ $storeCta ? $storeCta->description : $setting->store_description }}
                </p>
                @php
                    $addr  = $storeCta ? $storeCta->extra_line1 : $setting->store_address;
                    $hours = $storeCta ? $storeCta->extra_line2 : $setting->store_hours;
                @endphp
                @if($addr || $hours)
                <div class="store-details">
                    @if($addr)
                    <div class="store-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span>{{ $addr }}</span>
                    </div>
                    @endif
                    @if($hours)
                    <div class="store-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $hours }}</span>
                    </div>
                    @endif
                </div>
                @endif
                @php
                    $btnText = $storeCta ? $storeCta->button_text : ($setting->store_button_text ?: 'Find Our Store');
                    $btnUrl  = $storeCta ? $storeCta->button_url  : ($setting->store_button_url ?? route('store-locator'));
                @endphp
                <a href="{{ $btnUrl }}" class="btn btn-primary btn-md">{{ $btnText }}</a>
            </div>

            {{-- Right: map / image column --}}
            <div class="store-map">
                @if($storeCta && $storeCta->image_url)
                    <img src="{{ $storeCta->image_url }}" alt="Our Flagship Store"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                @else
                    @php $mapAddress = $addr ?: 'DHA Phase 6, Lahore, Pakistan'; @endphp
                    <iframe
                        src="https://www.google.com/maps?q={{ urlencode($mapAddress) }}&output=embed"
                        style="width:100%;height:100%;border:0;display:block;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        title="Map showing our flagship store location"
                        aria-label="Map showing our flagship store location: {{ $mapAddress }}">
                    </iframe>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ─── BOTTOM BANNER ───────────────────────────────────────── --}}
    @foreach($banners->where('position', 'bottom') as $banner)
    <div class="homepage-promo-banner" style="background:linear-gradient(135deg,#1a1a2e,#c9a96e);padding:2rem;text-align:center;color:#fff;position:relative;overflow:hidden;">
        @if($banner->image_url)<img src="{{ $banner->image_url }}" alt="" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.25;">@endif
        <div style="position:relative;z-index:1;">
            @if($banner->badge_text)<span style="display:inline-block;background:rgba(255,255,255,.15);font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.25rem .75rem;border-radius:20px;margin-bottom:.75rem;">{{ $banner->badge_text }}</span>@endif
            <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 .5rem;">{{ $banner->title }}</h2>
            @if($banner->subtitle)<p style="margin:.25rem 0 1rem;opacity:.85;">{{ $banner->subtitle }}</p>@endif
            @if($banner->button_text)<a href="{{ $banner->button_url ?? '#' }}" class="btn btn-outline btn-md" style="border-color:#fff;color:#fff;">{{ $banner->button_text }}</a>@endif
        </div>
    </div>
    @endforeach

@endsection

@push('scripts')
<script>
// Hero slider
(function(){
    const imgs = document.querySelectorAll('.hero-bg-img');
    const dots = document.querySelectorAll('.hero-dot[data-dot]');
    if(!imgs.length || imgs.length < 2) return;
    let cur = 0;
    function goTo(n){
        imgs[cur].style.opacity='0'; dots[cur]?.classList.remove('active');
        cur=(n+imgs.length)%imgs.length;
        imgs[cur].style.opacity='1'; dots[cur]?.classList.add('active');
    }
    dots.forEach(d=>d.addEventListener('click',()=>goTo(+d.dataset.dot)));
    setInterval(()=>goTo(cur+1), 5000);
})();

// Countdown
(function(){
    const el=document.querySelector('.countdown[data-end]');
    if(!el||!el.dataset.end) return;
    const end=new Date(el.dataset.end).getTime();
    const hh=document.getElementById('countdown-hh');
    const mm=document.getElementById('countdown-mm');
    const ss=document.getElementById('countdown-ss');
    function tick(){
        const d=end-Date.now(); if(d<=0){hh.textContent=mm.textContent=ss.textContent='00';return;}
        const t=Math.floor(d/1000);
        hh.textContent=String(Math.floor(t/3600)).padStart(2,'0');
        mm.textContent=String(Math.floor(t%3600/60)).padStart(2,'0');
        ss.textContent=String(t%60).padStart(2,'0');
    }
    tick(); setInterval(tick,1000);
})();
</script>
@endpush
