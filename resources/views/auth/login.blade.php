@extends('layouts.app')
@section('title', 'Staff Login — Amsaz Cosmetics')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:3rem 1rem;background:var(--color-bg-alt);">
<div style="width:100%;max-width:420px;">

    {{-- Brand --}}
    <div style="text-align:center;margin-bottom:2rem;">
        <a href="{{ route('home') }}" style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--color-primary);text-decoration:none;letter-spacing:1px;">
            Amsaz Cosmetics
        </a>
        <p style="margin:.5rem 0 0;color:var(--color-text-muted);font-size:.9rem;">Admin &amp; Staff Portal</p>
    </div>

    {{-- Card --}}
    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2.25rem;">

        {{-- Session status --}}
        @if (session('status'))
        <div style="background:#d1fae5;color:#065f46;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.875rem;">
            {{ session('status') }}
        </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.875rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group" style="margin-bottom:1.1rem;">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-input" type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="admin@Amsaz Cosmetics.com"
                       required autofocus autocomplete="username">
            </div>

            {{-- Password --}}
            <div class="form-group" style="margin-bottom:1.1rem;">
                <label class="form-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password"
                       placeholder="••••••••"
                       required autocomplete="current-password">
            </div>

            {{-- Remember + Forgot --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-text-muted);cursor:pointer;">
                    <input type="checkbox" name="remember" id="remember_me"
                           style="width:15px;height:15px;accent-color:var(--color-accent);">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   style="font-size:.8rem;color:var(--color-accent);text-decoration:none;font-weight:600;">
                    Forgot password?
                </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                Sign In
            </button>
        </form>

        {{-- Divider --}}
        <div style="display:flex;align-items:center;gap:.75rem;margin:1.75rem 0 1.25rem;">
            <div style="flex:1;height:1px;background:var(--color-border);"></div>
            <span style="font-size:.75rem;color:var(--color-text-muted);white-space:nowrap;">Not an admin?</span>
            <div style="flex:1;height:1px;background:var(--color-border);"></div>
        </div>

        {{-- Customer links --}}
        <div style="display:flex;gap:.75rem;">
            <a href="{{ route('customer.login') }}"
               style="flex:1;text-align:center;padding:.65rem;border:1.5px solid var(--color-border);border-radius:var(--radius-lg);font-size:.85rem;font-weight:600;color:var(--color-primary);text-decoration:none;transition:border-color .15s;"
               onmouseover="this.style.borderColor='var(--color-accent)'"
               onmouseout="this.style.borderColor='var(--color-border)'">
                Customer Sign In
            </a>
            <a href="{{ route('customer.register') }}"
               style="flex:1;text-align:center;padding:.65rem;border:1.5px solid var(--color-border);border-radius:var(--radius-lg);font-size:.85rem;font-weight:600;color:var(--color-primary);text-decoration:none;transition:border-color .15s;"
               onmouseover="this.style.borderColor='var(--color-accent)'"
               onmouseout="this.style.borderColor='var(--color-border)'">
                Create Account
            </a>
        </div>

    </div>

    <p style="text-align:center;margin-top:1.25rem;font-size:.78rem;color:var(--color-text-muted);">
        &copy; {{ date('Y') }} Amsaz Cosmetics. All rights reserved.
    </p>

</div>
</div>
@endsection
