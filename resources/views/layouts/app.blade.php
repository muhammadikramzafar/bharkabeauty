<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BharkaBeauty — Premium Luxury Cosmetics & Skincare Pakistan')</title>
    <meta name="description" content="@yield('meta_description', 'Pakistan\'s most curated luxury beauty destination. Shop Makeup, Skincare, Haircare, Fragrances and more from top global brands.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    @stack('styles')
</head>
<body>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')

</body>
</html>
