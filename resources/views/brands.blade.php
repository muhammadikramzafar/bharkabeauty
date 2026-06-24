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
                        @if($brand->logo)
                            <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" loading="lazy">
                        @else
                            <span class="brand-name-text">{{ $brand->name }}</span>
                        @endif
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
