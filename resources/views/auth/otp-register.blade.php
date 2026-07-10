@extends('layouts.app')
@section('title', 'Create Account — AmsazBeauty')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:3rem 1rem;background:var(--color-bg-alt);">
<div style="width:100%;max-width:440px;">

    <div style="text-align:center;margin-bottom:2rem;">
        <a href="{{ route('home') }}" style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--color-primary);text-decoration:none;letter-spacing:1px;">
            AmsazBeauty
        </a>
        <p style="margin:.5rem 0 0;color:var(--color-text-muted);font-size:.9rem;">Create your free account</p>
    </div>

    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2.25rem;">

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.875rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('customer.register.submit') }}">
            @csrf

            {{-- Name --}}
            <div class="form-group" style="margin-bottom:1.1rem;">
                <label class="form-label" for="name">Full Name</label>
                <input class="form-input {{ $errors->has('name') ? 'border-red-500' : '' }}"
                       type="text" id="name" name="name"
                       value="{{ old('name') }}" placeholder="Muhammad Ali" required autofocus>
            </div>

            {{-- Mobile --}}
            <div class="form-group" style="margin-bottom:1.1rem;">
                <label class="form-label" for="phone">Mobile Number</label>
                <div style="display:flex;gap:.5rem;">
                    <span class="form-input" style="width:64px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:var(--color-bg-alt);color:var(--color-text-muted);font-weight:600;font-size:.875rem;cursor:default;">
                        🇵🇰
                    </span>
                    <input class="form-input {{ $errors->has('phone') ? 'border-red-500' : '' }}"
                           type="tel" id="phone" name="phone"
                           value="{{ old('phone') }}" placeholder="03001234567"
                           pattern="^(\+92|0)[0-9]{9,10}$" required style="flex:1;">
                </div>
                @error('phone')
                <p style="font-size:.78rem;color:#dc2626;margin:.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-input {{ $errors->has('email') ? 'border-red-500' : '' }}"
                       type="email" id="email" name="email"
                       value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')
                <p style="font-size:.78rem;color:#dc2626;margin:.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- OTP notice --}}
            <div style="background:var(--color-bg-alt);border-radius:8px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.8rem;color:var(--color-text-muted);display:flex;gap:.6rem;align-items:flex-start;">
                <span style="font-size:1rem;flex-shrink:0;">📲</span>
                <span>A 6-digit verification code will be sent to <strong>both</strong> your mobile number and email.</span>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                Create Account &amp; Send Code
            </button>
        </form>

        <p style="text-align:center;margin-top:1.5rem;font-size:.875rem;color:var(--color-text-muted);">
            Already have an account?
            <a href="{{ route('customer.login') }}" style="color:var(--color-accent);font-weight:600;">Sign in</a>
        </p>
    </div>

    <p style="text-align:center;margin-top:1.25rem;font-size:.78rem;color:var(--color-text-muted);">
        By creating an account you agree to our
        <a href="#" style="color:var(--color-accent);">Terms &amp; Conditions</a>
    </p>
</div>
</div>
@endsection
