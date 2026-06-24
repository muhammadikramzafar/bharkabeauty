@extends('layouts.app')

@section('title', 'Find a Store — BharkaBeauty')

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">Store Locator</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">Find a Store</h1>
            <p class="page-hero-subtitle">Visit us in person for expert consultations and exclusive in-store experiences.</p>
        </div>
    </section>

    <section class="section">
        <div class="container store-locator-layout">

            <!-- Search -->
            <div class="store-search-wrap">
                <input type="text" id="store-search" placeholder="Search by city or area..." class="form-control store-search-input" aria-label="Search stores">
            </div>

            <!-- Stores List -->
            <div class="stores-list">
                @forelse($stores ?? [] as $store)
                    <div class="store-card">
                        <h3 class="store-card-name">{{ $store->name }}</h3>
                        <p class="store-card-address">{{ $store->address }}</p>
                        <p class="store-card-hours">{{ $store->hours }}</p>
                        <a href="tel:{{ $store->phone }}" class="store-card-phone">{{ $store->phone }}</a>
                    </div>
                @empty
                    <div class="store-card">
                        <h3 class="store-card-name">BharkaBeauty — Flagship Store</h3>
                        <p class="store-card-address">DHA Phase 6, Main Boulevard, Lahore, Pakistan</p>
                        <p class="store-card-hours">Mon–Sat: 10:00 AM – 9:00 PM | Sun: 12:00 PM – 8:00 PM</p>
                        <a href="tel:+923001234567" class="store-card-phone">+92 300 1234567</a>
                    </div>
                @endforelse
            </div>

            <!-- Map Placeholder -->
            <div class="store-map-container">
                <div class="store-map-placeholder">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=800&h=400&fit=crop" alt="Store map" loading="lazy">
                    <p>DHA Phase 6, Lahore</p>
                </div>
            </div>

        </div>
    </section>

@endsection
