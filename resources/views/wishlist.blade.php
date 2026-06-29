@extends('layouts.app')

@section('title', 'Wishlist — BharkaBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">Wishlist</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;">

    <div style="display:flex;align-items:baseline;gap:.75rem;margin-bottom:2rem;padding-bottom:1.25rem;border-bottom:2px solid var(--color-primary);">
        <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--color-primary);margin:0;">My Wishlist</h1>
        <span style="font-size:.9rem;color:var(--color-text-muted);">{{ count($wishlistItems) }} {{ count($wishlistItems) == 1 ? 'item' : 'items' }}</span>
    </div>

    @if(empty($wishlistItems))
    <div style="text-align:center;padding:5rem 1rem;">
        <div style="width:80px;height:80px;border-radius:50%;background:var(--color-bg-alt);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--color-border)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
            </svg>
        </div>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--color-primary);margin:0 0 .5rem;">Your wishlist is empty</h2>
        <p style="color:var(--color-text-muted);margin:0 0 1.75rem;font-size:.9rem;">Save your favourite products and shop them later.</p>
        <a href="{{ route('category.index') }}" class="btn btn-primary">Explore Products</a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.5rem;">
        @foreach($wishlistItems as $productId => $item)
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
            <a href="{{ route('product.show', $item['slug']) }}" style="display:block;aspect-ratio:1;overflow:hidden;background:var(--color-bg-alt);">
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:100%;height:100%;object-fit:cover;transition:transform .3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </a>
            <div style="padding:1rem;">
                @if($item['brand'])
                <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--color-accent);margin:0 0 .25rem;">{{ $item['brand'] }}</p>
                @endif
                <h3 style="font-size:.9rem;font-weight:700;color:var(--color-primary);margin:0 0 .5rem;line-height:1.35;">
                    <a href="{{ route('product.show', $item['slug']) }}" style="color:inherit;text-decoration:none;">{{ $item['name'] }}</a>
                </h3>
                <p style="font-size:1rem;font-weight:800;color:var(--color-primary);margin:0 0 .75rem;">PKR {{ number_format($item['price']) }}</p>

                <div style="display:flex;gap:.5rem;">
                    <form method="POST" action="{{ route('cart.add') }}" style="flex:1;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary" style="width:100%;height:38px;font-size:.82rem;">Add to Bag</button>
                    </form>
                    <form method="POST" action="{{ route('wishlist.remove') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        <button type="submit"
                                style="width:38px;height:38px;border:1.5px solid var(--color-border);border-radius:var(--radius-md);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--color-text-muted);transition:all .15s;"
                                onmouseover="this.style.borderColor='#dc2626';this.style.color='#dc2626'"
                                onmouseout="this.style.borderColor='var(--color-border)';this.style.color='var(--color-text-muted)'"
                                title="Remove from wishlist">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection
