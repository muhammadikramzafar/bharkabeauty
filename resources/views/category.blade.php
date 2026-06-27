@extends('layouts.app')

@section('title', ($pageTitle ?? 'Shop') . ' — BharkaBeauty')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('category.index') }}">Shop</a></li>
                    @if(isset($rootCategory) && $rootCategory)
                        <li aria-current="page">{{ $rootCategory->name }}</li>
                    @else
                        <li aria-current="page">All Products</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    @php $heroBg = $rootCategory->image_url ?? null; @endphp
    <section class="category-hero{{ $heroBg ? ' category-hero--has-image' : '' }}"
        @if($heroBg) style="background-image:url('{{ $heroBg }}')" @endif>
        @if($heroBg)<div class="category-hero__overlay"></div>@endif
        <div class="container" style="position:relative;z-index:2;">
            <h1 class="category-hero__title{{ $heroBg ? ' category-hero__title--light' : '' }}">{{ $pageTitle ?? 'Shop All' }}</h1>
            <p class="category-hero__desc{{ $heroBg ? ' category-hero__desc--light' : '' }}">{{ $pageDescription ?? 'Discover our curated collection of premium beauty products.' }}</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="category-layout container">

        @include('partials.sidebar')

        <!-- Product Grid -->
        <div class="products-area">

            <!-- Toolbar -->
            <div class="products-toolbar">
                <p class="products-count">
                    Showing <strong>{{ $products->total() ?? 0 }}</strong> products
                </p>
                <div class="toolbar-right">
                    <select class="sort-select" id="sort-select" aria-label="Sort products">
                        <option value="featured"   {{ request('sort', 'featured') == 'featured'   ? 'selected' : '' }}>Featured</option>
                        <option value="price-asc"  {{ request('sort') == 'price-asc'  ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="newest"     {{ request('sort') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" role="list">
                @forelse($products ?? [] as $product)
                    @include('partials.product-card', ['product' => $product])
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:4rem 1rem;color:#9ca3af;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:48px;height:48px;margin:0 auto 1rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        <p style="font-size:1.1rem;font-weight:600;margin-bottom:.5rem;">No products found</p>
                        <p style="font-size:.9rem;">Try adjusting your filters or <a href="{{ route('category.index') }}" style="color:var(--color-primary);">browse all products</a>.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($products) && $products->hasPages())
                <div class="pagination-wrap">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
<script>
// Sort dropdown: redirect preserving current filters
(function () {
    var sel = document.getElementById('sort-select');
    if (!sel) return;
    sel.addEventListener('change', function () {
        var url = new URL(window.location.href);
        if (this.value === 'featured') {
            url.searchParams.delete('sort');
        } else {
            url.searchParams.set('sort', this.value);
        }
        url.searchParams.delete('page'); // reset to page 1
        window.location.href = url.toString();
    });
})();
</script>
@endpush
