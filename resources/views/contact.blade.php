@extends('layouts.app')

@section('title', 'Contact Us — BharkaBeauty')

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="page-hero">
        <div class="container">
            <h1 class="page-hero-title">Get in Touch</h1>
            <p class="page-hero-subtitle">We typically respond within 2–4 hours during business hours.</p>
        </div>
    </section>

    <section class="section">
        <div class="container contact-layout">

            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Contact Information</h2>
                <div class="contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    <div>
                        <strong>Phone</strong>
                        <p>+92 300 1234567</p>
                    </div>
                </div>
                <div class="contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <div>
                        <strong>Email</strong>
                        <p>hello@bharkabeauty.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <div>
                        <strong>Address</strong>
                        <p>DHA Phase 6, Lahore, Pakistan</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrap">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="contact-form">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label for="name">Full Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="form-control @error('name') is-invalid @enderror" placeholder="Your full name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="form-control" placeholder="+92 300 1234567">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address <span style="color:#ef4444;">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               class="form-control" placeholder="How can we help you?">
                    </div>
                    <div class="form-group">
                        <label for="message">Message <span style="color:#ef4444;">*</span></label>
                        <textarea id="message" name="message" rows="5" required
                                  class="form-control @error('message') is-invalid @enderror"
                                  placeholder="Tell us more about your enquiry…">{{ old('message') }}</textarea>
                        @error('message') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                </form>
            </div>

        </div>
    </section>

@endsection
