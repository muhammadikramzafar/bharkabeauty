<article class="product-card" role="listitem">
    <div class="product-image-wrap">
        <a href="{{ route('product.show', $product->slug ?? 'product') }}">
            <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=600&h=600&fit=crop' }}"
                 alt="{{ $product->name ?? 'Product' }}" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
        </a>
        @if(isset($product->discount_percent) && $product->discount_percent > 0)
            <span class="product-badge badge-sale" aria-label="Sale">{{ $product->discount_percent }}% OFF</span>
        @elseif(isset($product->is_new) && $product->is_new)
            <span class="product-badge badge-new">New</span>
        @endif
        <button class="product-wishlist" aria-label="Add to wishlist" data-wishlist data-product="{{ $product->id ?? '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
        </button>
    </div>
    <div class="product-info">
        <p class="product-brand">{{ $product->brand->name ?? 'Brand' }}</p>
        <h3 class="product-name">
            <a href="{{ route('product.show', $product->slug ?? 'product') }}">{{ $product->name ?? 'Product Name' }}</a>
        </h3>
        <div class="product-pricing">
            <span class="price-current">PKR {{ number_format($product->sale_price ?? $product->price ?? 0) }}</span>
            @if(isset($product->price) && isset($product->sale_price) && $product->sale_price < $product->price)
                <span class="price-original">PKR {{ number_format($product->price) }}</span>
            @endif
        </div>
    </div>
    <div class="product-footer">
        <form method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id ?? 0 }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn-add-to-bag">Add to Bag</button>
        </form>
    </div>
</article>
