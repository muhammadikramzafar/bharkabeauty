@extends('layouts.app')

@section('title', 'All Brands — AmsazBeauty')

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">Brands</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="brands-page">
        <div class="container">
            <div class="section-header">
                <h1 class="section-title">All Brands</h1>
                <p class="section-subtitle">Shop from Pakistan's widest collection of authentic beauty brands</p>
            </div>

            <!-- Search -->
            <div class="brand-alpha-filter">
                <div class="brand-search">
                    <svg class="brand-search__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    <input type="text" id="brand-search-input" class="brand-search__input" placeholder="Search brands…" aria-label="Search brands" autocomplete="off">
                </div>
            </div>

            <!-- Brands Grid -->
            <div class="brands-page-grid">
                @forelse($brands ?? [] as $brand)
                    <a href="{{ route('category.index', ['brand' => $brand->slug]) }}"
                       class="brand-tile">
                        <span class="brand-tile__logo">
                            @if($brand->logo_url)
                                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" loading="lazy">
                            @else
                                <span class="brand-tile__placeholder">{{ strtoupper(substr($brand->name, 0, 1)) }}</span>
                            @endif
                        </span>
                        <span class="brand-tile__name">{{ $brand->name }}</span>
                    </a>
                @empty
                    @foreach(['Maybelline', "L'Oréal Paris", 'Garnier', 'Huda Beauty', 'The Ordinary', 'CeraVe', 'Neutrogena', 'Essence', 'Rivaj UK', 'Golden Rose', 'Revlon', 'Nivea'] as $name)
                        <div class="brand-tile">
                            <span class="brand-tile__logo">
                                <span class="brand-tile__placeholder">{{ strtoupper(substr($name, 0, 1)) }}</span>
                            </span>
                            <span class="brand-tile__name">{{ $name }}</span>
                        </div>
                    @endforeach
                @endforelse
            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
(function () {
    var tiles       = document.querySelectorAll('.brand-tile');
    var searchInput = document.getElementById('brand-search-input');
    if (!tiles.length || !searchInput) return;

    searchInput.addEventListener('input', function () {
        var searchTerm = this.value.trim().toLowerCase();
        tiles.forEach(function (tile) {
            var nameEl = tile.querySelector('.brand-tile__name');
            var name   = nameEl ? nameEl.textContent.toLowerCase() : '';
            tile.style.display = name.indexOf(searchTerm) !== -1 ? '' : 'none';
        });
    });
})();
</script>
@endpush
