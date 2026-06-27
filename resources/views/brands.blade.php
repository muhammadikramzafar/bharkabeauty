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
                        <div style="width:100%;height:72px;display:flex;align-items:center;justify-content:center;overflow:hidden;border-radius:var(--radius-md);margin-bottom:.6rem;">
                            @if($brand->logo_url)
                                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" loading="lazy"
                                     style="width:100%;height:100%;object-fit:contain;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#c9a96e,#a07840);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.1rem;border-radius:var(--radius-md);">
                                    {{ strtoupper(substr($brand->name,0,1)) }}
                                </div>
                            @endif
                        </div>
                        <p class="brand-name" style="font-weight:600;font-size:.8rem;line-height:1.3;margin:0 0 .15rem;">{{ $brand->name }}</p>
                        <p class="brand-cat" style="font-size:.72rem;color:#9ca3af;margin:0;">{{ $brand->products_count }} products</p>
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
