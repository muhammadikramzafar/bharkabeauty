@extends('layouts.app')

@section('title', ($product->name ?? 'Product') . ' — BharkaBeauty')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('category.index') }}">Shop</a></li>
                    <li aria-current="page">{{ $product->name ?? 'Product' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container product-detail-layout">

        <!-- Gallery -->
        <div class="product-gallery">
            <div class="gallery-main">
                <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=600&h=600&fit=crop' }}"
                     alt="{{ $product->name ?? 'Product' }}" id="gallery-main-img" loading="eager">
                <button class="gallery-wishlist" aria-label="Save to wishlist" data-wishlist>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </button>
            </div>
            <div class="gallery-thumbs">
                @foreach($product->all_image_urls ?? [] as $imgUrl)
                    <button class="gallery-thumb {{ $loop->first ? 'active' : '' }}"
                            onclick="document.getElementById('gallery-main-img').src='{{ $imgUrl }}'">
                        <img src="{{ $imgUrl }}" alt="Product view {{ $loop->iteration }}" loading="lazy">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info-panel">
            <div class="product-meta-top">
                <span class="product-brand-tag">{{ $product->brand->name ?? 'Brand' }}</span>
                @if(isset($product->discount_percent) && $product->discount_percent > 0)
                    <span class="product-badge badge-sale">{{ $product->discount_percent }}% OFF</span>
                @endif
            </div>

            <h1 class="product-detail-title">{{ $product->name ?? 'Product Name' }}</h1>

            <div class="product-detail-pricing">
                <span class="price-current">PKR {{ number_format($product->sale_price ?? $product->price ?? 0) }}</span>
                @if(isset($product->price) && isset($product->sale_price) && $product->sale_price < $product->price)
                    <span class="price-original">PKR {{ number_format($product->price) }}</span>
                    <span class="price-save-badge">Save PKR {{ number_format($product->price - $product->sale_price) }}</span>
                @endif
            </div>

            <p class="product-short-desc">{{ $product->short_description ?? 'Premium quality beauty product.' }}</p>

            <!-- Add to Bag Form -->
            <form method="POST" action="{{ route('cart.add') }}" class="product-add-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id ?? 1 }}">

                <div class="qty-selector">
                    <button type="button" class="qty-btn" data-action="decrease">−</button>
                    <input type="number" name="quantity" value="1" min="1" max="10" class="qty-input" aria-label="Quantity">
                    <button type="button" class="qty-btn" data-action="increase">+</button>
                </div>

                <div class="product-cta-row">
                    <button type="submit" class="btn btn-primary btn-lg btn-full">Add to Bag</button>
                    <button type="button" class="btn btn-outline btn-lg" data-wishlist data-product="{{ $product->id ?? 1 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                        Wishlist
                    </button>
                </div>
            </form>

            <!-- Trust Badges -->
            <div class="trust-badges">
                <div class="trust-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>100% Authentic</span></div>
                <div class="trust-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg><span>Free Returns</span></div>
                <div class="trust-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375"/></svg><span>Free Delivery</span></div>
            </div>
        </div>

    </div>

    {{-- Product Description Tabs --}}
    @if($product->description)
    <div class="container" style="margin-top:3rem;margin-bottom:3rem;">
        <div class="admin-card" style="padding:2rem;">
            <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:1rem;">Product Description</h2>
            <div style="color:#555;line-height:1.85;font-size:.95rem;">
                {{ $product->description }}
            </div>
        </div>
    </div>
    @endif

    {{-- Related Products --}}
    @if(isset($related) && $related->isNotEmpty())
    <section class="section flash-sale-section" style="padding-top:0;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">You May Also Like</h2>
            </div>
            <div class="products-grid" role="list">
                @foreach($related as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
