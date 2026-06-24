@extends('layouts.app')

@section('title', ($pageTitle ?? 'Shop') . ' — BharkaBeauty')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">{{ $pageTitle ?? 'Shop' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <section class="category-hero">
        <div class="container">
            <h1 class="category-hero__title">{{ $pageTitle ?? 'Shop All' }}</h1>
            <p class="category-hero__desc">{{ $pageDescription ?? 'Discover our curated collection of premium beauty products.' }}</p>
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
                    Showing <strong>{{ $products->count() ?? 0 }}</strong> products
                </p>
                <div class="toolbar-right">
                    <select class="sort-select" aria-label="Sort products">
                        <option value="featured">Featured</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                        <option value="rating">Top Rated</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" role="list">
                @forelse($products ?? [] as $product)
                    @include('partials.product-card', ['product' => $product])
                @empty
                    {{-- Static placeholder --}}
                    <article class="product-card" role="listitem">
                        <div class="product-image-wrap">
                            <img src="https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=600&h=600&fit=crop" alt="Product" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                            <span class="product-badge badge-new">New</span>
                        </div>
                        <div class="product-info">
                            <p class="product-brand">Maybelline</p>
                            <h3 class="product-name">Fit Me Foundation</h3>
                            <div class="product-pricing">
                                <span class="price-current">PKR 2,200</span>
                            </div>
                        </div>
                        <div class="product-footer">
                            <button class="btn-add-to-bag">Add to Bag</button>
                        </div>
                    </article>
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
