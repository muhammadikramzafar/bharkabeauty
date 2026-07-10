@extends('layouts.app')
@section('title', 'Profile Settings — AmsazBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('customer.dashboard') }}">My Account</a></li>
                <li aria-current="page">Settings</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;display:grid;grid-template-columns:260px 1fr;gap:2rem;align-items:start;">

    @include('profile._sidebar')

    <div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:1.5rem;">Profile Settings</h1>

        @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;border-radius:10px;padding:.9rem 1.25rem;margin-bottom:1.5rem;font-size:.9rem;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:10px;padding:.9rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;">

            <form method="POST" action="{{ route('customer.settings.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-grid" style="margin-bottom:1.25rem;">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-input" type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input class="form-input" type="tel" id="phone" name="phone"
                               value="{{ old('phone', $user->phone) }}" placeholder="03XX-XXXXXXX">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:1.75rem;">
                    <label class="form-label" for="email">Email Address</label>
                    <input class="form-input" type="email" id="email" value="{{ $user->email }}"
                           disabled style="background:var(--color-bg-alt);color:var(--color-text-muted);cursor:not-allowed;">
                    <p style="font-size:.78rem;color:var(--color-text-muted);margin:.4rem 0 0;">Email cannot be changed. Contact support if needed.</p>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
            </form>

        </div>

        {{-- Account info box --}}
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.5rem;margin-top:1.25rem;">
            <h3 style="font-size:.875rem;font-weight:700;margin-bottom:1rem;">Account Info</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;font-size:.875rem;">
                <div>
                    <p style="color:var(--color-text-muted);margin:0 0 2px;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">Member Since</p>
                    <p style="font-weight:600;margin:0;">{{ $user->created_at->format('M Y') }}</p>
                </div>
                <div>
                    <p style="color:var(--color-text-muted);margin:0 0 2px;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">Login Method</p>
                    <p style="font-weight:600;margin:0;">Email OTP</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
