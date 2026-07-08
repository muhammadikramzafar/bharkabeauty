@php
    $seo         = \App\Models\SeoSetting::instance();
    $separator   = $seo->title_separator ?: '—';
    $siteName    = $seo->site_name ?: 'BharkaBeauty';

    // Resolve page title
    $pageTitle   = trim(View::yieldContent('title'));
    if (empty($pageTitle)) {
        $pageTitle = $seo->default_title ?: ($siteName . ' ' . $separator . ' Premium Beauty Pakistan');
    }

    // Resolve meta description
    $metaDesc    = trim(View::yieldContent('meta_description'));
    if (empty($metaDesc)) {
        $metaDesc = $seo->default_description ?: 'Pakistan\'s most curated luxury beauty destination.';
    }

    // Resolve meta keywords
    $metaKeywords = trim(View::yieldContent('meta_keywords'));
    if (empty($metaKeywords)) $metaKeywords = $seo->default_keywords ?? '';

    // OG values
    $ogTitle  = $pageTitle;
    $ogDesc   = $metaDesc;
    $ogImage  = trim(View::yieldContent('og_image'));
    if (empty($ogImage)) $ogImage = $seo->og_image_url ?? '';
    $ogUrl    = ($seo->canonical_base_url ? rtrim($seo->canonical_base_url, '/') : '') . request()->getPathInfo();
    $canonUrl = ($seo->canonical_base_url ? rtrim($seo->canonical_base_url, '/') : url('')) . request()->getPathInfo();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ── Primary Meta ────────────────────────────────── --}}
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    @if($metaKeywords)
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <link rel="canonical" href="{{ $canonUrl }}">

    {{-- ── Open Graph ──────────────────────────────────── --}}
    <meta property="og:title"       content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:type"        content="{{ $seo->og_type ?: 'website' }}">
    <meta property="og:url"         content="{{ $ogUrl }}">
    <meta property="og:site_name"   content="{{ $siteName }}">
    @if($ogImage)
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    @endif

    {{-- ── Twitter Card ────────────────────────────────── --}}
    <meta name="twitter:card"        content="{{ $seo->twitter_card ?: 'summary_large_image' }}">
    <meta name="twitter:title"       content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    @if($seo->twitter_site)
    <meta name="twitter:site"        content="{{ $seo->twitter_site }}">
    @endif
    @if($ogImage)
    <meta name="twitter:image"       content="{{ $ogImage }}">
    @endif

    {{-- ── Google Analytics 4 ─────────────────────────── --}}
    @if($seo->google_analytics_id)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seo->google_analytics_id }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $seo->google_analytics_id }}');</script>
    @endif

    {{-- ── Google Tag Manager ──────────────────────────── --}}
    @if($seo->google_tag_manager_id)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $seo->google_tag_manager_id }}');</script>
    @endif

    {{-- ── Facebook Pixel ──────────────────────────────── --}}
    @if($seo->facebook_pixel_id)
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{{ $seo->facebook_pixel_id }}');fbq('track','PageView');</script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $seo->facebook_pixel_id }}&ev=PageView&noscript=1"/></noscript>
    @endif

    {{-- ── Fonts ───────────────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    @stack('styles')

    {{-- ── Custom Head Code (Admin-injected) ──────────── --}}
    @if($seo->custom_head_code)
    {!! $seo->custom_head_code !!}
    @endif
</head>
<body>

    {{-- GTM noscript fallback --}}
    @if($seo->google_tag_manager_id)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $seo->google_tag_manager_id }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- ── Global Toast Notifications ─────────────────── --}}
    <div id="toast-container" style="position:fixed;top:1.25rem;right:1.25rem;z-index:9999;display:flex;flex-direction:column;gap:.6rem;pointer-events:none;"></div>

    @if(session('success') || session('error') || session('info'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        showToast({{ json_encode(session('success')) }}, 'success');
        @endif
        @if(session('error'))
        showToast({{ json_encode(session('error')) }}, 'error');
        @endif
        @if(session('info'))
        showToast({{ json_encode(session('info')) }}, 'info');
        @endif
    });
    </script>
    @endif

    <script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
    @stack('scripts')

    {{-- ── Custom Body Code (Admin-injected) ──────────── --}}
    @if($seo->custom_body_code)
    {!! $seo->custom_body_code !!}
    @endif

</body>
</html>
