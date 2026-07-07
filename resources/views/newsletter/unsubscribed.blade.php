@extends('layouts.app')
@section('title', 'Unsubscribed — BharkaBeauty')

@section('content')
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb"><ol><li><a href="{{ route('home') }}">Home</a></li><li aria-current="page">Newsletter</li></ol></nav>
    </div>
</div>

<section class="page-hero">
    <div class="container" style="text-align:center;max-width:540px;">
        <div style="width:72px;height:72px;border-radius:50%;background:#f3e8d8;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="1.8" width="32"><path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="page-hero-title" style="font-size:1.8rem;">{{ $message }}</h1>
        <p style="color:#6b7280;margin:1rem 0 2rem;">You won't receive any more emails from BharkaBeauty newsletter.</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-md">Return to Homepage</a>
    </div>
</section>
@endsection
