@extends('layouts.admin')
@section('title', 'Site Settings')
@section('page_title', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- TAB NAV --}}
    <div class="admin-tabs">
        <button type="button" class="admin-tab active" data-tab="general">General</button>
        <button type="button" class="admin-tab" data-tab="contact">Contact</button>
        <button type="button" class="admin-tab" data-tab="social">Social Links</button>
        <button type="button" class="admin-tab" data-tab="footer">Footer</button>
        <button type="button" class="admin-tab" data-tab="seo">SEO</button>
    </div>

    {{-- GENERAL --}}
    <div class="admin-tab-panel active" id="tab-general">
        <div class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">General</h2></div>
            <div class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Company Name <span class="required">*</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name', $settings->company_name) }}" class="form-control @error('company_name') is-invalid @enderror" required>
                        @error('company_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $settings->tagline) }}" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Logo</label>
                        @if($settings->logo)
                            <div class="media-preview"><img src="{{ Storage::disk('public')->url($settings->logo) }}" alt="Logo" style="max-height:60px;"></div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="form-control @error('logo') is-invalid @enderror">
                        <small class="form-hint">PNG, SVG, WebP · Max 2 MB</small>
                        @error('logo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Favicon</label>
                        @if($settings->favicon)
                            <div class="media-preview"><img src="{{ Storage::disk('public')->url($settings->favicon) }}" alt="Favicon" style="max-height:32px;"></div>
                        @endif
                        <input type="file" name="favicon" accept="image/*" class="form-control @error('favicon') is-invalid @enderror">
                        <small class="form-hint">PNG or ICO · Max 512 KB</small>
                        @error('favicon')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTACT --}}
    <div class="admin-tab-panel" id="tab-contact">
        <div class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Contact Details</h2></div>
            <div class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" class="form-control @error('contact_email') is-invalid @enderror">
                        @error('contact_email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>WhatsApp</label>
                        <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings->contact_whatsapp) }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="contact_address" rows="3" class="form-control">{{ old('contact_address', $settings->contact_address) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- SOCIAL LINKS --}}
    <div class="admin-tab-panel" id="tab-social">
        <div class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Social Links</h2></div>
            <div class="admin-form">
                @foreach(['facebook','instagram','twitter','youtube','tiktok','pinterest'] as $network)
                <div class="form-group">
                    <label>{{ ucfirst($network) }}</label>
                    <input type="url" name="social_{{ $network }}" value="{{ old('social_'.$network, $settings->{'social_'.$network}) }}" placeholder="https://{{ $network }}.com/yourpage" class="form-control @error('social_'.$network) is-invalid @enderror">
                    @error('social_'.$network)<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="admin-tab-panel" id="tab-footer">
        <div class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Footer Content</h2></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>About Text</label>
                    <textarea name="footer_about" rows="4" class="form-control">{{ old('footer_about', $settings->footer_about) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Copyright Line</label>
                    <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings->footer_copyright) }}" placeholder="© 2025 Amsaz Cosmetics. All rights reserved." class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- SEO --}}
    <div class="admin-tab-panel" id="tab-seo">
        <div class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">SEO & Analytics</h2></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $settings->meta_title) }}" maxlength="160" class="form-control">
                    <small class="form-hint">Max 160 characters</small>
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="3" maxlength="320" class="form-control">{{ old('meta_description', $settings->meta_description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Google Analytics ID</label>
                    <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings->google_analytics_id) }}" placeholder="G-XXXXXXXXXX" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.admin-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.admin-tab, .admin-tab-panel').forEach(el => el.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
