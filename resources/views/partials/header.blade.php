<!-- ─── ANNOUNCEMENT BAR ─────────────────────────────────── -->
<div class="announcement-bar">
    Free delivery on orders above PKR 2,000 &nbsp;|&nbsp; <a href="{{ route('category.index', ['cat' => 'offers']) }}">Shop Flash Sale →</a>
</div>

<!-- ─── HEADER ───────────────────────────────────────────── -->
<header class="site-header" role="banner">
    <div class="header-top">
        <!-- Logo -->
        <div class="header-logo">
            <a href="{{ route('home') }}" aria-label="BharkaBeauty Home">Bharka<span>Beauty</span></a>
        </div>

        <!-- Search -->
        <div class="header-search">
            <svg class="header-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
            </svg>
            <input type="search" placeholder="Search for products, brands..." aria-label="Search products" />
        </div>

        <!-- Actions -->
        <div class="header-actions">
            <a href="{{ route('store-locator') }}" class="header-action-btn" aria-label="Find a store">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
            </a>
            <a href="#wishlist" class="header-action-btn" aria-label="Wishlist">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </a>
            <a href="{{ route('cart') }}" class="header-action-btn" aria-label="Shopping bag">
                <span style="position:relative; display:inline-flex;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                    </svg>
                    <span class="cart-badge">0</span>
                </span>
            </a>
            @auth
                <a href="{{ route('profile.edit') }}" class="header-action-btn" aria-label="My Account">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="header-action-btn" aria-label="Sign In">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </a>
            @endauth
        </div>

        <!-- Hamburger -->
        <button class="hamburger" id="hamburger-btn" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    <!-- Nav -->
    <nav class="header-nav" aria-label="Main navigation">
        @php $activeCat = request()->route('cat'); @endphp
        <div class="header-nav-inner">
            <a href="{{ route('category.index', ['cat' => 'makeup']) }}"    class="nav-link {{ $activeCat == 'makeup' ? 'active' : '' }}">Makeup</a>
            <a href="{{ route('category.index', ['cat' => 'skincare']) }}"  class="nav-link {{ $activeCat == 'skincare' ? 'active' : '' }}">Skincare</a>
            <a href="{{ route('category.index', ['cat' => 'haircare']) }}"  class="nav-link {{ $activeCat == 'haircare' ? 'active' : '' }}">Haircare</a>
            <a href="{{ route('category.index', ['cat' => 'fragrance']) }}" class="nav-link {{ $activeCat == 'fragrance' ? 'active' : '' }}">Fragrances</a>
            <a href="{{ route('category.index', ['cat' => 'bath-body']) }}" class="nav-link {{ $activeCat == 'bath-body' ? 'active' : '' }}">Bath &amp; Body</a>
            <a href="{{ route('category.index', ['cat' => 'tools']) }}"     class="nav-link {{ $activeCat == 'tools' ? 'active' : '' }}">Tools</a>
            <a href="{{ route('brands') }}"                                 class="nav-link {{ request()->routeIs('brands') ? 'active' : '' }}">Brands</a>
            <a href="{{ route('services.index') }}"                         class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('blog.index') }}"                             class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
            <a href="{{ route('category.index', ['cat' => 'offers']) }}"    class="nav-link offers {{ $activeCat == 'offers' ? 'active' : '' }}">Offers</a>
        </div>
    </nav>
</header>

<!-- ─── MOBILE MENU ───────────────────────────────────────── -->
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-label="Main menu">
    <div class="mobile-menu-header">
        <a href="{{ route('home') }}" style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--color-primary);">Bharka<span style="color:var(--color-accent)">Beauty</span></a>
        <button class="mobile-menu-close" id="mobile-menu-close" aria-label="Close menu">✕</button>
    </div>
    <div class="mobile-menu-actions">
        <input class="mobile-search" type="search" placeholder="Search products, brands..." aria-label="Search" />
    </div>
    <nav class="mobile-menu-nav" aria-label="Mobile navigation">
        <a href="{{ route('category.index', ['cat' => 'makeup']) }}"    class="mobile-nav-link">Makeup</a>
        <a href="{{ route('category.index', ['cat' => 'skincare']) }}"  class="mobile-nav-link">Skincare</a>
        <a href="{{ route('category.index', ['cat' => 'haircare']) }}"  class="mobile-nav-link">Haircare</a>
        <a href="{{ route('category.index', ['cat' => 'fragrance']) }}" class="mobile-nav-link">Fragrances</a>
        <a href="{{ route('category.index', ['cat' => 'bath-body']) }}" class="mobile-nav-link">Bath &amp; Body</a>
        <a href="{{ route('category.index', ['cat' => 'tools']) }}"     class="mobile-nav-link">Tools</a>
        <a href="{{ route('brands') }}"                                 class="mobile-nav-link">Brands</a>
        <a href="{{ route('services.index') }}"                         class="mobile-nav-link">Services</a>
        <a href="{{ route('blog.index') }}"                             class="mobile-nav-link">Blog</a>
        <a href="{{ route('category.index', ['cat' => 'offers']) }}"    class="mobile-nav-link offers">🔥 Offers</a>
        <a href="{{ route('store-locator') }}"                          class="mobile-nav-link">📍 Find a Store</a>
        @auth
            <a href="{{ route('profile.edit') }}"                       class="mobile-nav-link">👤 My Account</a>
        @else
            <a href="{{ route('login') }}"                              class="mobile-nav-link">👤 Sign In</a>
        @endauth
    </nav>
</div>
