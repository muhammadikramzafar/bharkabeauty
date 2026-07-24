@extends('layouts.app')

@section('title', $page->seo_title ?? $page->title . ' — Amsaz Cosmetics')
@section('meta_description', $page->seo_description ?? '')

@section('content')

    @if($page->banner_image)
        <div class="page-banner">
            <img src="{{ Storage::disk('public')->url($page->banner_image) }}" alt="{{ $page->title }}" loading="eager">
        </div>
    @endif

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="container cms-page-content">
            <h1 class="page-hero-title">{{ $page->title }}</h1>
            <div class="cms-body">
                {!! $page->description !!}
            </div>
        </div>
    </section>

@endsection
