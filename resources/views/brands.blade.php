@extends('layouts.app')

@section('title', 'All Brands — BharkaBeauty')

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

            <!-- Alphabetical Filter -->
            <div class="brand-alpha-filter">
                <button class="alpha-btn active" data-alpha="all">All</button>
                @foreach(range('A', 'Z') as $letter)
                    <button class="alpha-btn" data-alpha="{{ $letter }}">{{ $letter }}</button>
                @endforeach
            </div>

            <!-- Brands Grid -->
            <div class="brands-grid">
                @forelse($brands ?? [] as $brand)
                    <a href="{{ route('category.index', ['brand' => $brand->slug]) }}" class="brand-card" data-alpha="{{ strtoupper(substr($brand->name, 0, 1)) }}">
                        @if($brand->logo_url)
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" loading="lazy" style="max-height:60px;max-width:130px;object-fit:contain;">
                        @else
                            <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#c9a96e,#a07840);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.1rem;margin:0 auto .5rem;">{{ strtoupper(substr($brand->name,0,1)) }}</div>
                        @endif
                        <p class="brand-name" style="margin-top:.5rem;font-weight:600;">{{ $brand->name }}</p>
                        <p class="brand-cat" style="font-size:.75rem;color:#9ca3af;">{{ $brand->products_count }} products</p>
                    </a>
                @empty
                    @foreach(['Maybelline', "L'Oréal Paris", 'Garnier', 'Huda Beauty', 'The Ordinary', 'CeraVe', 'Neutrogena', 'Essence', 'Rivaj UK', 'Golden Rose', 'Revlon', 'Nivea'] as $name)
                        <div class="brand-card">
                            <span class="brand-name-text">{{ $name }}</span>
                        </div>
                    @endforeach
                @endforelse
            </div>

        </div>
    </section>

@endsection
