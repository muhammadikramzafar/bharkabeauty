@extends('layouts.admin')
@section('title', 'Homepage Settings')
@section('page_title', 'Homepage Settings')

@section('content')


<form method="POST" action="{{ route('admin.homepage.settings.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    {{-- TAB NAV --}}
    <div class="admin-tabs" id="hp-tabs">
        <button type="button" class="admin-tab active" data-tab="seo">SEO</button>
        <button type="button" class="admin-tab" data-tab="flash">Flash Sale</button>
        <button type="button" class="admin-tab" data-tab="about">About Section</button>
        <button type="button" class="admin-tab" data-tab="store">Store CTA</button>
        <button type="button" class="admin-tab" data-tab="newsletter">Newsletter</button>
        <button type="button" class="admin-tab" data-tab="visibility">Visibility</button>
    </div>

    {{-- SEO --}}
    <div class="admin-tab-panel active" id="tab-seo">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Homepage SEO</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>SEO Title <span class="form-hint">(max 160 chars)</span></label>
                    <input type="text" name="seo_title" value="{{ old('seo_title', $setting->seo_title) }}" maxlength="160" class="form-control @error('seo_title') is-invalid @enderror">
                    @error('seo_title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Meta Description <span class="form-hint">(max 320 chars)</span></label>
                    <textarea name="seo_description" rows="3" maxlength="320" class="form-control @error('seo_description') is-invalid @enderror">{{ old('seo_description', $setting->seo_description) }}</textarea>
                    @error('seo_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Keywords <span class="form-hint">(comma-separated)</span></label>
                    <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $setting->seo_keywords) }}" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- Flash Sale --}}
    <div class="admin-tab-panel" id="tab-flash">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Flash Sale Section</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="hidden" name="show_flash_sale" value="0">
                        <input type="checkbox" name="show_flash_sale" value="1" {{ $setting->show_flash_sale ? 'checked' : '' }}>
                        Show Flash Sale section
                    </label>
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="flash_sale_title" value="{{ old('flash_sale_title', $setting->flash_sale_title) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Section Subtitle</label>
                    <input type="text" name="flash_sale_subtitle" value="{{ old('flash_sale_subtitle', $setting->flash_sale_subtitle) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Sale End Date & Time</label>
                    <input type="datetime-local" name="flash_sale_end"
                           value="{{ old('flash_sale_end', $setting->flash_sale_end ? $setting->flash_sale_end->format('Y-m-d\TH:i') : '') }}"
                           class="form-control">
                    <small class="form-hint">The countdown timer uses this date.</small>
                </div>
            </div>
        </div>
    </div>

    {{-- About Section --}}
    <div class="admin-tab-panel" id="tab-about">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">About Section</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="hidden" name="show_about" value="0">
                        <input type="checkbox" name="show_about" value="1" {{ $setting->show_about ? 'checked' : '' }}>
                        Show About section on homepage
                    </label>
                </div>
                <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input type="text" name="about_eyebrow" value="{{ old('about_eyebrow', $setting->about_eyebrow) }}" placeholder="e.g. Our Story" class="form-control">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="about_title" value="{{ old('about_title', $setting->about_title) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="about_description" rows="5" class="form-control">{{ old('about_description', $setting->about_description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    @if($setting->about_image)
                        <div style="margin-bottom:.5rem;">
                            <img src="{{ Storage::disk('public')->url($setting->about_image) }}" style="max-height:120px;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" name="about_image" accept="image/*" class="form-control">
                </div>
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" name="about_button_text" value="{{ old('about_button_text', $setting->about_button_text) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Button URL</label>
                    <input type="text" name="about_button_url" value="{{ old('about_button_url', $setting->about_button_url) }}" placeholder="/about" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- Store CTA --}}
    <div class="admin-tab-panel" id="tab-store">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Flagship Store CTA</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="store_title" value="{{ old('store_title', $setting->store_title) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="store_description" rows="3" class="form-control">{{ old('store_description', $setting->store_description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="store_address" value="{{ old('store_address', $setting->store_address) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Hours</label>
                    <input type="text" name="store_hours" value="{{ old('store_hours', $setting->store_hours) }}" placeholder="Mon–Sat: 10:00 AM – 9:00 PM" class="form-control">
                </div>
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" name="store_button_text" value="{{ old('store_button_text', $setting->store_button_text) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Button URL</label>
                    <input type="text" name="store_button_url" value="{{ old('store_button_url', $setting->store_button_url) }}" placeholder="/store-locator" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- Newsletter --}}
    <div class="admin-tab-panel" id="tab-newsletter">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Newsletter CTA</h3></div>
            <div class="admin-form">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="newsletter_title" value="{{ old('newsletter_title', $setting->newsletter_title) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Subtitle</label>
                    <input type="text" name="newsletter_subtitle" value="{{ old('newsletter_subtitle', $setting->newsletter_subtitle) }}" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- Visibility --}}
    <div class="admin-tab-panel" id="tab-visibility">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Section Visibility</h3></div>
            <div class="admin-form">
                @foreach([
                    'show_hero'          => 'Hero Slider',
                    'show_categories'    => 'Shop by Category',
                    'show_flash_sale'    => 'Flash Sale',
                    'show_brands'        => 'Client Logos / Shop by Brand',
                    'show_featured'      => 'Featured Collections',
                    'show_about'         => 'About Section',
                    'show_services'      => 'Service Highlights',
                    'show_counters'      => 'Stats Counters',
                    'show_testimonials'  => 'Testimonials',
                    'show_store_cta'     => 'Flagship Store CTA',
                    'show_newsletter'    => 'Newsletter CTA',
                ] as $key => $label)
                <div class="form-group" style="margin-bottom:.75rem;">
                    <label class="form-checkbox-label">
                        <input type="hidden" name="{{ $key }}" value="0">
                        <input type="checkbox" name="{{ $key }}" value="1"
                               {{ old($key, $setting->$key) ? 'checked' : '' }}>
                        {{ $label }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
        <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline">Back to Homepage</a>
    </div>

</form>

@endsection

@push('scripts')
<script>
const tabs = document.querySelectorAll('#hp-tabs .admin-tab');
const panels = document.querySelectorAll('.admin-tab-panel');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        panels.forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
