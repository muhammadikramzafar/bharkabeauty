@extends('layouts.app')

@section('title', 'Find Our Store — BharkaBeauty')

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">Store Locator</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Hero --}}
<div style="background:var(--color-bg-alt);border-bottom:1px solid var(--color-border);padding:3rem 0 2.5rem;">
    <div class="container" style="text-align:center;">
        <p style="font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--color-accent);margin-bottom:.6rem;">Visit Us</p>
        <h1 style="font-family:var(--font-display);font-size:clamp(1.9rem,4vw,2.75rem);font-weight:800;color:var(--color-primary);margin:0 0 .75rem;">Find Our Store</h1>
        <p style="font-size:1rem;color:var(--color-text-muted);max-width:500px;margin:0 auto;line-height:1.65;">
            Come experience BharkaBeauty in person — expert consultations, exclusive testers, and beauty advice from our team.
        </p>
    </div>
</div>

{{-- Main layout: info + map --}}
<section style="padding:3.5rem 0 4rem;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:2.5rem;align-items:start;">

            {{-- Left: Store info --}}
            <div>
                {{-- Store card --}}
                <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">

                    {{-- Card header --}}
                    <div style="background:var(--color-primary);padding:1.5rem 1.75rem;">
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.35rem;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;flex-shrink:0;">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span style="color:rgba(255,255,255,.75);font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;">Flagship Store</span>
                        </div>
                        <h2 style="color:#fff;font-family:var(--font-display);font-size:1.35rem;font-weight:800;margin:0;">BharkaBeauty</h2>
                        <p style="color:rgba(255,255,255,.8);font-size:.85rem;margin:.3rem 0 0;">Rawalpindi, Pakistan</p>
                    </div>

                    {{-- Card body --}}
                    <div style="padding:1.75rem;">

                        {{-- Address --}}
                        <div style="display:flex;gap:.9rem;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border);margin-bottom:1.25rem;">
                            <div style="width:36px;height:36px;background:var(--color-bg-alt);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-muted);margin:0 0 .3rem;">Address</p>
                                <p style="font-size:.95rem;font-weight:600;color:var(--color-primary);margin:0;line-height:1.5;">
                                    New Morgah Road, Morgah<br>
                                    Rawalpindi, Pakistan<br>
                                    <span style="font-size:.85rem;font-weight:400;color:var(--color-text-muted);">Near Attock Refinery Limited</span>
                                </p>
                            </div>
                        </div>

                        {{-- Hours --}}
                        <div style="display:flex;gap:.9rem;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border);margin-bottom:1.25rem;">
                            <div style="width:36px;height:36px;background:var(--color-bg-alt);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-muted);margin:0 0 .4rem;">Opening Hours</p>
                                <div style="font-size:.875rem;color:var(--color-primary);line-height:1.7;">
                                    <div style="display:flex;justify-content:space-between;gap:1rem;">
                                        <span style="color:var(--color-text-muted);">Mon – Sat</span>
                                        <span style="font-weight:600;">10:00 AM – 9:00 PM</span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;gap:1rem;">
                                        <span style="color:var(--color-text-muted);">Sunday</span>
                                        <span style="font-weight:600;">12:00 PM – 8:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div style="display:flex;gap:.9rem;margin-bottom:1.5rem;">
                            <div style="width:36px;height:36px;background:var(--color-bg-alt);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.85 12 19.79 19.79 0 0 1 1.8 3.4 2 2 0 0 1 3.77 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-muted);margin:0 0 .3rem;">Phone</p>
                                <a href="tel:+923001234567" style="font-size:.95rem;font-weight:600;color:var(--color-primary);text-decoration:none;">+92 300 1234567</a>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <a href="https://www.google.com/maps/search/New+Morgah+Road+Morgah+Rawalpindi+near+Attock+Refinery+Limited"
                           target="_blank" rel="noopener"
                           class="btn btn-primary btn-md" style="width:100%;text-align:center;display:block;">
                            Get Directions
                        </a>

                    </div>
                </div>

                {{-- Info note --}}
                <p style="font-size:.8rem;color:var(--color-text-muted);margin:1rem 0 0;text-align:center;line-height:1.6;">
                    Walk-ins welcome. For beauty consultations,<br>call ahead to book your slot.
                </p>
            </div>

            {{-- Right: Map --}}
            <div>
                <div style="border-radius:var(--radius-xl);overflow:hidden;border:1.5px solid var(--color-border);box-shadow:0 4px 24px rgba(0,0,0,.07);">
                    <iframe
                        src="https://maps.google.com/maps?q=Morgah+Rawalpindi+near+Attock+Refinery+Limited&t=&z=14&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="480"
                        style="display:block;border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="BharkaBeauty Store Location">
                    </iframe>
                </div>
                <p style="font-size:.78rem;color:var(--color-text-muted);margin:.75rem 0 0;text-align:center;">
                    New Morgah Road, Morgah, Rawalpindi — Near Attock Refinery Limited
                </p>
            </div>

        </div>
    </div>
</section>

{{-- Responsive --}}
@push('scripts')
<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@endsection
