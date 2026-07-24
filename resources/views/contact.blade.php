@extends('layouts.app')

@section('title', 'Contact Us — Amsaz Cosmetics')

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">Contact Us</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Hero --}}
<div style="background:var(--color-bg-alt);border-bottom:1px solid var(--color-border);padding:3rem 0 2.5rem;">
    <div class="container" style="text-align:center;">
        <p style="font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--color-accent);margin-bottom:.6rem;">We'd Love to Hear From You</p>
        <h1 style="font-family:var(--font-display);font-size:clamp(1.9rem,4vw,2.75rem);font-weight:800;color:var(--color-primary);margin:0 0 .75rem;">Get in Touch</h1>
        <p style="font-size:1rem;color:var(--color-text-muted);max-width:480px;margin:0 auto;line-height:1.65;">
            Questions about an order, a product, or just want to say hello? We typically respond within 2–4 hours during business hours.
        </p>
    </div>
</div>

{{-- Main --}}
<section style="padding:3.5rem 0 4rem;">
    <div class="container">
        <div style="display:grid;grid-template-columns:360px 1fr;gap:2.5rem;align-items:start;">

            {{-- Left: contact info --}}
            <div>
                {{-- Dark info card --}}
                <div style="background:var(--color-primary);border-radius:var(--radius-xl);padding:2.25rem;color:#fff;margin-bottom:1.5rem;">
                    <h2 style="font-family:var(--font-display);font-size:1.3rem;font-weight:800;color:#fff;margin:0 0 .4rem;">Contact Information</h2>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.65);margin:0 0 2rem;line-height:1.6;">Reach us through any of these channels.</p>

                    {{-- Phone --}}
                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem;">
                        <div style="width:40px;height:40px;background:rgba(255,255,255,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.85 12 19.79 19.79 0 011.8 3.4 2 2 0 013.77 1.22h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.91 9.91a16 16 0 006.18 6.18l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.5);margin:0 0 .25rem;">Phone</p>
                            <a href="tel:+923001234567" style="color:#fff;text-decoration:none;font-size:.95rem;font-weight:600;">+92 300 1234567</a>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem;">
                        <div style="width:40px;height:40px;background:rgba(255,255,255,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.5);margin:0 0 .25rem;">Email</p>
                            <a href="mailto:hello@Amsaz Cosmetics.com" style="color:#fff;text-decoration:none;font-size:.95rem;font-weight:600;">hello@Amsaz Cosmetics.com</a>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem;">
                        <div style="width:40px;height:40px;background:rgba(255,255,255,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.5);margin:0 0 .25rem;">Address</p>
                            <p style="color:#fff;font-size:.95rem;font-weight:600;margin:0;line-height:1.5;">New Morgah Road, Morgah<br>Rawalpindi, Pakistan</p>
                        </div>
                    </div>

                    {{-- Hours --}}
                    <div style="display:flex;align-items:flex-start;gap:1rem;">
                        <div style="width:40px;height:40px;background:rgba(255,255,255,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.5);margin:0 0 .25rem;">Hours</p>
                            <p style="color:#fff;font-size:.875rem;margin:0;line-height:1.7;">Mon–Sat: 10:00 AM – 9:00 PM<br>Sunday: 12:00 PM – 8:00 PM</p>
                        </div>
                    </div>

                    {{-- Decorative dots --}}
                    <div style="margin-top:2.5rem;display:flex;gap:.5rem;">
                        <div style="width:10px;height:10px;border-radius:50%;background:var(--color-accent);opacity:.9;"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,.3);"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,.15);"></div>
                    </div>
                </div>

                {{-- WhatsApp CTA --}}
                <a href="https://wa.me/923001234567" target="_blank" rel="noopener"
                   style="display:flex;align-items:center;gap:.9rem;background:#25d366;color:#fff;border-radius:var(--radius-lg);padding:1rem 1.25rem;text-decoration:none;font-weight:700;font-size:.9rem;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Chat on WhatsApp
                </a>
            </div>

            {{-- Right: Form --}}
            <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2.25rem;">

                <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--color-primary);margin:0 0 .4rem;">Send Us a Message</h2>
                <p style="font-size:.875rem;color:var(--color-text-muted);margin:0 0 1.75rem;">Fill in the form below and we'll get back to you shortly.</p>

                @if(session('success'))
                <div style="background:#d1fae5;color:#065f46;border-radius:8px;padding:.9rem 1.1rem;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;display:flex;align-items:center;gap:.6rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.5rem;font-size:.875rem;">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    {{-- Name + Phone --}}
                    <div class="form-grid" style="margin-bottom:1.1rem;">
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name <span style="color:#ef4444;">*</span></label>
                            <input class="form-input" type="text" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Muhammad Ali" required>
                            @error('name')<p style="font-size:.78rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number</label>
                            <input class="form-input" type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}" placeholder="+92 300 1234567">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group" style="margin-bottom:1.1rem;">
                        <label class="form-label" for="email">Email Address <span style="color:#ef4444;">*</span></label>
                        <input class="form-input" type="email" id="email" name="email"
                               value="{{ old('email') }}" placeholder="you@example.com" required>
                        @error('email')<p style="font-size:.78rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Subject --}}
                    <div class="form-group" style="margin-bottom:1.1rem;">
                        <label class="form-label" for="subject">Subject <span style="color:#ef4444;">*</span></label>
                        <input class="form-input" type="text" id="subject" name="subject"
                               value="{{ old('subject') }}" placeholder="How can we help you?" required>
                    </div>

                    {{-- Message --}}
                    <div class="form-group" style="margin-bottom:1.75rem;">
                        <label class="form-label" for="message">Message <span style="color:#ef4444;">*</span></label>
                        <textarea class="form-input" id="message" name="message" rows="5" required
                                  style="height:auto;resize:vertical;"
                                  placeholder="Tell us more about your enquiry…">{{ old('message') }}</textarea>
                        @error('message')<p style="font-size:.78rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns:360px"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@endsection
