<header class="admin-topbar">
    <button class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle sidebar">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
    </button>

    <div class="admin-topbar-title">
        @yield('page_title', 'Dashboard')
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('home') }}" class="admin-topbar-btn" target="_blank" title="View Site">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Site
        </a>
        <div class="admin-user-menu">
            <span class="admin-user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
            <div class="admin-user-info">
                <p class="admin-user-name">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="admin-user-role">{{ Auth::user()->getRoleNames()->first() ?? 'Administrator' }}</p>
            </div>
        </div>
    </div>
</header>
