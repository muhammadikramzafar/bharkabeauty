@php
    $base = rtrim($seo->canonical_base_url ?: config('app.url'), '/');
    $now  = now()->toAtomString();

    $staticPages = [
        ['url' => $base . '/',              'priority' => '1.0', 'freq' => 'daily',   'mod' => $now],
        ['url' => $base . '/shop',          'priority' => '0.9', 'freq' => 'daily',   'mod' => $now],
        ['url' => $base . '/blog',          'priority' => '0.9', 'freq' => 'daily',   'mod' => $now],
        ['url' => $base . '/services',      'priority' => '0.8', 'freq' => 'weekly',  'mod' => $now],
        ['url' => $base . '/brands',        'priority' => '0.7', 'freq' => 'weekly',  'mod' => $now],
        ['url' => $base . '/about',         'priority' => '0.6', 'freq' => 'monthly', 'mod' => $now],
        ['url' => $base . '/contact',       'priority' => '0.6', 'freq' => 'monthly', 'mod' => $now],
        ['url' => $base . '/store-locator', 'priority' => '0.5', 'freq' => 'monthly', 'mod' => $now],
    ];
@endphp
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Static Pages --}}
    @foreach($staticPages as $p)
    <url>
        <loc>{{ $p['url'] }}</loc>
        <lastmod>{{ $p['mod'] }}</lastmod>
        <changefreq>{{ $p['freq'] }}</changefreq>
        <priority>{{ $p['priority'] }}</priority>
    </url>
    @endforeach

    {{-- Blog Posts --}}
    @foreach($posts as $post)
    <url>
        <loc>{{ $base }}/blog/{{ $post->slug }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Blog Categories --}}
    @foreach($blogCats as $cat)
    <url>
        <loc>{{ $base }}/blog/category/{{ $cat->slug }}</loc>
        <lastmod>{{ $cat->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    {{-- Services --}}
    @foreach($services as $service)
    <url>
        <loc>{{ $base }}/services/{{ $service->slug }}</loc>
        <lastmod>{{ $service->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Service Categories --}}
    @foreach($serviceCats as $cat)
    <url>
        <loc>{{ $base }}/services?category={{ $cat->slug }}</loc>
        <lastmod>{{ $cat->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach

    {{-- CMS Pages --}}
    @foreach($pages as $page)
    <url>
        <loc>{{ $base }}/page/{{ $page->slug }}</loc>
        <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach

</urlset>
