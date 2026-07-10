@extends('layouts.app')

@section('title', 'About Us — AmsazBeauty')

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Hero -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">About AmsazBeauty</h1>
            <p class="page-hero-subtitle">Beauty That Celebrates You</p>
        </div>
    </section>

    <!-- Story -->
    <section class="about-story-section">
        <div class="container about-content">
            <div class="about-stats-col">
                <h2>Our Story</h2>
                <div class="about-stats">
                    <div class="about-stat">
                        <span class="stat-number">200+</span>
                        <span class="stat-label">Premium Brands</span>
                    </div>
                    <div class="about-stat">
                        <span class="stat-number">10,000+</span>
                        <span class="stat-label">Products</span>
                    </div>
                    <div class="about-stat">
                        <span class="stat-number">50,000+</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                    <div class="about-stat">
                        <span class="stat-number">All Pakistan</span>
                        <span class="stat-label">Delivery Coverage</span>
                    </div>
                </div>
            </div>
            <div class="about-text">
                <p>AmsazBeauty was born from a simple belief — that everyone deserves access to the world's finest beauty products. Founded in Lahore, Pakistan, we have curated a collection that spans premium international brands and beloved local favourites.</p>
                <p>From flawless foundations to nourishing skincare rituals, every product in our range is hand-selected by our team of beauty experts to ensure it meets the highest standards of quality, authenticity, and performance.</p>
                <p>We believe beauty is not about perfection — it's about feeling confident in your own skin. That's why we celebrate diversity, inclusivity, and self-expression in everything we do.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section" style="text-align:center;">
        <div class="container">
            <h2 class="section-title">Ready to Discover Your Beauty?</h2>
            <p class="section-subtitle">Shop our curated collection of luxury beauty essentials.</p>
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </section>

@endsection
