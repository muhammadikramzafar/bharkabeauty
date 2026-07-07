<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — BharkaBeauty</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />

    @stack('styles')
</head>
<body class="admin-body">

    @include('admin.partials.sidebar')

    <div class="admin-main">

        @include('admin.partials.topbar')

        <div class="admin-content">
            @if(session('success'))
                <div class="admin-alert admin-alert--success" role="status">
                    <svg class="admin-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    <span class="admin-alert__message">{{ session('success') }}</span>
                    <button type="button" class="admin-alert__close" aria-label="Dismiss">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="admin-alert admin-alert--error" role="status">
                    <svg class="admin-alert__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
                    </svg>
                    <span class="admin-alert__message">{{ session('error') }}</span>
                    <button type="button" class="admin-alert__close" aria-label="Dismiss">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

    </div>

    @stack('scripts')

<script>
// Mobile sidebar toggle
const sidebarToggle = document.getElementById('adminSidebarToggle');
const sidebar       = document.getElementById('adminSidebar');
if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
    document.addEventListener('click', e => {
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}

// Dismissible flash alerts
document.querySelectorAll('.admin-alert__close').forEach(btn => {
    btn.addEventListener('click', () => {
        const alertEl = btn.closest('.admin-alert');
        alertEl.addEventListener('transitionend', () => alertEl.remove(), { once: true });
        alertEl.classList.add('admin-alert--dismissed');
    });
});
</script>

</body>
</html>
