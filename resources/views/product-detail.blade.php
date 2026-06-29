@extends('layouts.app')

@section('title', ($product->name ?? 'Product') . ' — BharkaBeauty')

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('category.index') }}">Shop</a></li>
                @if($product->category)
                <li><a href="{{ route('category.index', ['cat' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main product section --}}
<div class="container" style="padding-top:2.5rem;padding-bottom:3rem;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start;">

        {{-- ── LEFT: Gallery ── --}}
        <div style="position:sticky;top:100px;">

            {{-- Main image --}}
            <div style="border-radius:var(--radius-xl);overflow:hidden;background:var(--color-bg-alt);aspect-ratio:1;position:relative;margin-bottom:1rem;">
                <img id="pd-main-img"
                     src="{{ $product->main_image }}"
                     alt="{{ $product->name }}"
                     style="width:100%;height:100%;object-fit:cover;"
                     loading="eager">

                {{-- Badges over image --}}
                <div style="position:absolute;top:1rem;left:1rem;display:flex;flex-direction:column;gap:.4rem;">
                    @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                    <span style="background:var(--color-sale,#e63946);color:#fff;font-size:.72rem;font-weight:800;padding:4px 10px;border-radius:50px;letter-spacing:.04em;">
                        {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                    </span>
                    @endif
                    @if($product->is_featured ?? false)
                    <span style="background:var(--color-accent);color:#fff;font-size:.72rem;font-weight:800;padding:4px 10px;border-radius:50px;letter-spacing:.04em;">
                        Featured
                    </span>
                    @endif
                </div>
            </div>

            {{-- Thumbnails --}}
            @php $images = $product->all_image_urls ?? []; @endphp
            @if(count($images) > 1)
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;">
                @foreach($images as $i => $url)
                <button onclick="document.getElementById('pd-main-img').src='{{ $url }}';document.querySelectorAll('.pd-thumb').forEach(t=>t.style.borderColor='var(--color-border)');this.style.borderColor='var(--color-accent)';"
                        class="pd-thumb"
                        style="width:72px;height:72px;border-radius:var(--radius-md);overflow:hidden;border:2px solid {{ $i===0?'var(--color-accent)':'var(--color-border)' }};cursor:pointer;background:var(--color-bg-alt);padding:0;transition:border-color .15s;">
                    <img src="{{ $url }}" alt="View {{ $i+1 }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── RIGHT: Info panel ── --}}
        <div>

            {{-- Brand + Category --}}
            <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.75rem;">
                @if($product->brand)
                <a href="{{ route('category.index', ['brand[]' => $product->brand->slug]) }}"
                   style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--color-accent);text-decoration:none;">
                    {{ $product->brand->name }}
                </a>
                @endif
                @if($product->category)
                <span style="color:var(--color-border);">·</span>
                <span style="font-size:.78rem;color:var(--color-text-muted);">{{ $product->category->name }}</span>
                @endif
            </div>

            {{-- Title --}}
            <h1 style="font-family:var(--font-display);font-size:clamp(1.5rem,3vw,2.1rem);font-weight:800;color:var(--color-primary);line-height:1.2;margin:0 0 1.1rem;">
                {{ $product->name }}
            </h1>

            {{-- Rating (static display) --}}
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;">
                <div style="display:flex;gap:2px;">
                    @for($s=1;$s<=5;$s++)
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $s<=4 ? 'var(--color-accent)' : 'none' }}" stroke="var(--color-accent)" stroke-width="1.5">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    @endfor
                </div>
                <span style="font-size:.82rem;color:var(--color-text-muted);">4.0 · 48 reviews</span>
            </div>

            {{-- Price --}}
            <div style="display:flex;align-items:baseline;gap:.9rem;flex-wrap:wrap;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--color-border);">
                <span style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--color-primary);">
                    PKR {{ number_format($product->sale_price ?? $product->price) }}
                </span>
                @if(isset($product->sale_price) && $product->sale_price && $product->sale_price < $product->price)
                <span style="font-size:1.1rem;color:var(--color-text-muted);text-decoration:line-through;">
                    PKR {{ number_format($product->price) }}
                </span>
                <span style="background:#fef2f2;color:#dc2626;font-size:.8rem;font-weight:700;padding:4px 12px;border-radius:50px;">
                    Save PKR {{ number_format($product->price - $product->sale_price) }}
                </span>
                @endif
            </div>

            {{-- Short description --}}
            @if($product->short_description)
            <p style="font-size:.95rem;color:var(--color-text-muted);line-height:1.75;margin-bottom:1.75rem;">
                {{ $product->short_description }}
            </p>
            @endif

            {{-- Stock indicator --}}
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.5rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:#16a34a;flex-shrink:0;"></div>
                <span style="font-size:.82rem;font-weight:600;color:#16a34a;">In Stock</span>
                <span style="color:var(--color-border);">·</span>
                <span style="font-size:.82rem;color:var(--color-text-muted);">Ships in 1–2 days</span>
            </div>

            {{-- Add to Bag --}}
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Qty + CTA row --}}
                <div style="display:flex;gap:.75rem;margin-bottom:1rem;">
                    {{-- Qty --}}
                    <div style="display:flex;align-items:center;border:1.5px solid var(--color-border);border-radius:var(--radius-md);overflow:hidden;flex-shrink:0;">
                        <button type="button" onclick="var i=document.getElementById('pd-qty');if(i.value>1)i.value--;"
                                style="width:42px;height:50px;border:none;background:transparent;font-size:1.2rem;cursor:pointer;color:var(--color-primary);">−</button>
                        <input id="pd-qty" type="number" name="quantity" value="1" min="1" max="99"
                               style="width:44px;height:50px;border:none;text-align:center;font-size:.95rem;font-weight:700;color:var(--color-primary);background:transparent;">
                        <button type="button" onclick="var i=document.getElementById('pd-qty');i.value=parseInt(i.value)+1;"
                                style="width:42px;height:50px;border:none;background:transparent;font-size:1.2rem;cursor:pointer;color:var(--color-primary);">+</button>
                    </div>

                    {{-- Add to Bag --}}
                    <button type="submit" class="btn btn-primary"
                            style="flex:1;height:50px;font-size:.95rem;font-weight:700;letter-spacing:.02em;">
                        Add to Bag
                    </button>
                </div>

                {{-- Wishlist --}}
                @php $pdInWishlist = array_key_exists($product->id, session('wishlist', [])); @endphp
                <button type="button"
                        data-wishlist-btn
                        data-product="{{ $product->id }}"
                        data-active="{{ $pdInWishlist ? 'true' : 'false' }}"
                        style="width:100%;height:46px;border:1.5px solid var(--color-border);border-radius:var(--radius-md);background:transparent;font-size:.9rem;font-weight:600;color:{{ $pdInWishlist ? 'var(--color-accent)' : 'var(--color-primary)' }};cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .15s;"
                        onmouseover="if(!this.classList.contains('active')){this.style.borderColor='var(--color-accent)';this.style.color='var(--color-accent)';}"
                        onmouseout="if(!this.classList.contains('active')){this.style.borderColor='var(--color-border)';this.style.color='var(--color-primary)';}">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="{{ $pdInWishlist ? 'var(--color-accent)' : 'none' }}"
                         stroke="{{ $pdInWishlist ? 'var(--color-accent)' : 'currentColor' }}"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                    </svg>
                    {{ $pdInWishlist ? 'Saved to Wishlist' : 'Save to Wishlist' }}
                </button>
            </form>

            {{-- Trust badges --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--color-border);">
                <div style="text-align:center;padding:.75rem .5rem;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .4rem;">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <p style="font-size:.72rem;font-weight:700;color:var(--color-primary);margin:0;">100% Authentic</p>
                </div>
                <div style="text-align:center;padding:.75rem .5rem;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .4rem;">
                        <path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    <p style="font-size:.72rem;font-weight:700;color:var(--color-primary);margin:0;">Easy Returns</p>
                </div>
                <div style="text-align:center;padding:.75rem .5rem;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .4rem;">
                        <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    <p style="font-size:.72rem;font-weight:700;color:var(--color-primary);margin:0;">Free Delivery</p>
                </div>
            </div>

            {{-- Delivery info --}}
            <div style="margin-top:1rem;padding:.9rem 1rem;border:1px solid var(--color-border);border-radius:var(--radius-md);display:flex;align-items:center;gap:.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <p style="font-size:.82rem;color:var(--color-text-muted);margin:0;line-height:1.5;">
                    Order before <strong style="color:var(--color-primary);">3:00 PM</strong> for same-day dispatch.
                    Free delivery on orders above <strong style="color:var(--color-primary);">PKR 2,000</strong>.
                </p>
            </div>

        </div>
    </div>
</div>

{{-- Description tab --}}
@if($product->description)
<div style="background:var(--color-bg-alt);border-top:1px solid var(--color-border);border-bottom:1px solid var(--color-border);padding:3rem 0;">
    <div class="container" style="max-width:780px;">
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--color-primary);margin:0 0 1.25rem;">About This Product</h2>
        <div style="color:var(--color-text-muted);line-height:1.85;font-size:.95rem;">
            {{ $product->description }}
        </div>
    </div>
</div>
@endif

{{-- Related products --}}
@if(isset($related) && $related->isNotEmpty())
<section class="section" style="padding-top:3rem;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">You May Also Like</h2>
        </div>
        <div class="products-grid" role="list">
            @foreach($related as $relProduct)
                @include('partials.product-card', ['product' => $relProduct])
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    .container > div[style*="grid-template-columns:1fr 1fr"] > div:first-child {
        position: static !important;
    }
}
</style>
@endpush

@endsection
