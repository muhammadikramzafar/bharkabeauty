@extends('layouts.app')
@section('title', 'Sign In — BharkaBeauty')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:3rem 1rem;background:var(--color-bg-alt);">
<div style="width:100%;max-width:420px;">

    <div style="text-align:center;margin-bottom:2rem;">
        <a href="{{ route('home') }}" style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--color-primary);text-decoration:none;letter-spacing:1px;">
            BharkaBeauty
        </a>
        <p style="margin:.5rem 0 0;color:var(--color-text-muted);font-size:.9rem;">Sign in with a one-time code</p>
    </div>

    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2.25rem;">

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.875rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('otp.send') }}">
            @csrf

            <div class="form-group" style="margin-bottom:.5rem;">
                <label class="form-label" for="identifier">Mobile Number or Email</label>
                <input class="form-input" type="text" id="identifier" name="identifier"
                       value="{{ old('identifier') }}"
                       placeholder="03001234567 or you@example.com"
                       required autofocus autocomplete="username">
            </div>

            <p style="font-size:.78rem;color:var(--color-text-muted);margin:0 0 1.5rem;">
                OTP will be sent to both your mobile and email.
            </p>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                Send Verification Code
            </button>
        </form>

        <p style="text-align:center;margin-top:1.5rem;font-size:.875rem;color:var(--color-text-muted);">
            New customer?
            <a href="{{ route('customer.register') }}" style="color:var(--color-accent);font-weight:600;">Create account</a>
        </p>

        <div style="border-top:1px solid var(--color-border);margin-top:1.5rem;padding-top:1.25rem;text-align:center;">
            <a href="{{ route('login') }}" style="font-size:.8rem;color:var(--color-text-muted);">
                Admin / Staff login →
            </a>
        </div>
    </div>

</div>
</div>
@endsection
