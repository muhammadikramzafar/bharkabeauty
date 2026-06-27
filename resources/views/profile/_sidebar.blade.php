@php
    $currentRoute = Route::currentRouteName();
    $nav = [
        ['route' => 'customer.dashboard', 'label' => 'Dashboard',     'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'customer.orders',    'label' => 'My Orders',      'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
        ['route' => 'customer.settings',  'label' => 'Profile Settings','icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ];
@endphp

<aside>
    {{-- User card --}}
    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.5rem;margin-bottom:1rem;text-align:center;">
        <div style="width:64px;height:64px;background:var(--color-accent);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.5rem;font-weight:800;color:#fff;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <p style="font-weight:700;margin:0 0 .2rem;font-size:.95rem;">{{ auth()->user()->name }}</p>
        <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;">{{ auth()->user()->email }}</p>
    </div>

    {{-- Nav --}}
    <nav style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
        @foreach($nav as $item)
        @php $active = $currentRoute === $item['route']; @endphp
        <a href="{{ route($item['route']) }}"
           style="display:flex;align-items:center;gap:.75rem;padding:.9rem 1.25rem;font-size:.9rem;font-weight:{{ $active ? '700' : '500' }};color:{{ $active ? 'var(--color-accent)' : 'var(--color-text)' }};text-decoration:none;background:{{ $active ? 'var(--color-bg-alt)' : 'transparent' }};border-left:3px solid {{ $active ? 'var(--color-accent)' : 'transparent' }};transition:all .15s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;flex-shrink:0;">
                <path d="{{ $item['icon'] }}"/>
            </svg>
            {{ $item['label'] }}
        </a>
        @endforeach

        {{-- Divider --}}
        <div style="border-top:1px solid var(--color-border);margin:.25rem 0;"></div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="display:flex;align-items:center;gap:.75rem;padding:.9rem 1.25rem;font-size:.9rem;font-weight:500;color:#dc2626;background:none;border:none;cursor:pointer;width:100%;text-align:left;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;flex-shrink:0;">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
    </nav>
</aside>
