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
            </div>
            <div class="categories-grid" role="list">
                <a href="{{ route('category.index', ['cat' => 'makeup']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg></div>
                    <span class="category-name">Makeup</span>
                </a>
                <a href="{{ route('category.index', ['cat' => 'skincare']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg></div>
                    <span class="category-name">Skincare</span>
                </a>
                <a href="{{ route('category.index', ['cat' => 'haircare']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg></div>
                    <span class="category-name">Haircare</span>
                </a>
                <a href="{{ route('category.index', ['cat' => 'fragrance']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg></div>
                    <span class="category-name">Fragrance</span>
                </a>
                <a href="{{ route('category.index', ['cat' => 'bath-body']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/></svg></div>
                    <span class="category-name">Bath &amp; Body</span>
                </a>
                <a href="{{ route('category.index', ['cat' => 'tools']) }}" class="category-item" role="listitem">
                    <div class="category-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/></svg></div>
                    <span class="category-name">Tools</span>
                </a>
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
                            <span style="font-size:2rem;line-height:1;">{{ $service->icon }}</span>
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

    {{-- ─── FLASH SALE ────────────────────────────────────────────── --}}
    @if($setting->show_flash_sale)
    <section class="section flash-sale-section" aria-labelledby="flash-sale-heading">
        <div class="container">
            <div class="flash-sale-header">
                <div class="flash-sale-left">
                    <h2 class="section-title" id="flash-sale-heading">{{ $setting->flash_sale_title ?: 'Flash Sale' }}</h2>
                    <p class="section-subtitle">{{ $setting->flash_sale_subtitle }}</p>
                </div>
                <div class="countdown" aria-label="Time remaining"
                     @if($setting->flash_sale_end) data-end="{{ $setting->flash_sale_end->toIso8601String() }}" @endif>
                    <div class="countdown-item"><span class="countdown-number" id="countdown-hh">00</span><span class="countdown-label">HH</span></div>
                    <span class="countdown-sep" aria-hidden="true">:</span>
                    <div class="countdown-item"><span class="countdown-number" id="countdown-mm">00</span><span class="countdown-label">MM</span></div>
                    <span class="countdown-sep" aria-hidden="true">:</span>
                    <div class="countdown-item"><span class="countdown-number" id="countdown-ss">00</span><span class="countdown-label">SS</span></div>
                </div>
            </div>
            <div class="products-grid" role="list">
                @forelse($flashSaleProducts ?? [] as $product)
                    @include('partials.product-card', ['product' => $product])
                @empty
                    <article class="product-card" role="listitem">
                        <div class="product-image-wrap">
                            <img src="https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=600&h=600&fit=crop" alt="Huda Beauty Lipstick" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                            <span class="product-badge badge-sale">27% OFF</span>
                            <button class="product-wishlist" aria-label="Add to wishlist"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg></button>
                        </div>
                        <div class="product-info">
                            <p class="product-brand">Huda Beauty</p>
                            <h3 class="product-name">Power Bullet Matte Lipstick</h3>
                            <div class="product-pricing"><span class="price-current">PKR 4,500</span><span class="price-original">PKR 6,200</span></div>
                        </div>
                        <div class="product-footer"><button class="btn-add-to-bag">Add to Bag</button></div>
                    </article>
                @endforelse
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
                        @if($logo->logo_url)<img src="{{ $logo->logo_url }}" alt="{{ $logo->name }}" style="max-height:36px;object-fit:contain;margin-bottom:.4rem;">@endif
                        <p class="brand-name">{{ $logo->name }}</p>
                        @if($logo->tagline)<p class="brand-cat">{{ $logo->tagline }}</p>@endif
                    </a>
                    @endforeach
                @else
                    <a href="{{ route('category.index', ['brand' => 'maybelline']) }}" class="brand-card"><p class="brand-name">Maybelline</p><p class="brand-cat">Makeup</p></a>
                    <a href="{{ route('category.index', ['brand' => 'loreal']) }}" class="brand-card"><p class="brand-name">L'Oréal Paris</p><p class="brand-cat">Makeup</p></a>
                    <a href="{{ route('category.index', ['brand' => 'garnier']) }}" class="brand-card"><p class="brand-name">Garnier</p><p class="brand-cat">Skincare</p></a>
                    <a href="{{ route('category.index', ['brand' => 'neutrogena']) }}" class="brand-card"><p class="brand-name">Neutrogena</p><p class="brand-cat">Skincare</p></a>
                    <a href="{{ route('category.index', ['brand' => 'ordinary']) }}" class="brand-card"><p class="brand-name">The Ordinary</p><p class="brand-cat">Skincare</p></a>
                    <a href="{{ route('category.index', ['brand' => 'cerave']) }}" class="brand-card"><p class="brand-name">CeraVe</p><p class="brand-cat">Skincare</p></a>
                    <a href="{{ route('category.index', ['brand' => 'huda']) }}" class="brand-card"><p class="brand-name">Huda Beauty</p><p class="brand-cat">Makeup</p></a>
                    <a href="{{ route('category.index', ['brand' => 'essence']) }}" class="brand-card"><p class="brand-name">Essence</p><p class="brand-cat">Makeup</p></a>
                    <a href="{{ route('category.index', ['brand' => 'rivaj']) }}" class="brand-card"><p class="brand-name">Rivaj UK</p><p class="brand-cat">Makeup</p></a>
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
