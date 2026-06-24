@extends('layouts.admin')
@section('title', 'Global SEO Settings')
@section('page_title', 'Global SEO Settings')

@push('styles')
<style>
.seo-tabs { display:flex; border-bottom:2px solid #f0e8da; margin-bottom:1.5rem; gap:.25rem; overflow-x:auto; }
.seo-tab  { padding:.65rem 1.25rem; font-size:.875rem; font-weight:600; color:#6b7280; cursor:pointer; border:none; background:none; border-bottom:3px solid transparent; margin-bottom:-2px; white-space:nowrap; transition:all .2s; }
.seo-tab.active  { color:#c9a96e; border-bottom-color:#c9a96e; }
.seo-tab:hover:not(.active) { color:#374151; }
.seo-panel { display:none; } .seo-panel.active { display:block; }
.char-counter { font-size:.75rem; color:#9ca3af; float:right; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start;">

        <div>
            {{-- Tabs --}}
            <div class="admin-card" style="margin-bottom:0;">
                <div class="seo-tabs">
                    <button type="button" class="seo-tab active" data-tab="general">General SEO</button>
                    <button type="button" class="seo-tab" data-tab="opengraph">Open Graph</button>
                    <button type="button" class="seo-tab" data-tab="analytics">Analytics</button>
                    <button type="button" class="seo-tab" data-tab="scripts">Code Injection</button>
                    <button type="button" class="seo-tab" data-tab="robots">Robots.txt</button>
                </div>

                {{-- ── General ── --}}
                <div class="seo-panel active admin-form" id="tab-general">

                    <div class="form-group">
                        <label>Site Name</label>
                        <input type="text" name="site_name" maxlength="120"
                               value="{{ old('site_name', $seo->site_name) }}" class="form-control"
                               placeholder="BharkaBeauty">
                        <small class="form-hint">Used in browser tab and OG tags.</small>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 120px;gap:1rem;">
                        <div class="form-group">
                            <label>Default Page Title</label>
                            <input type="text" name="default_title" maxlength="160"
                                   value="{{ old('default_title', $seo->default_title) }}" class="form-control"
                                   placeholder="BharkaBeauty — Premium Beauty in Pakistan"
                                   oninput="document.getElementById('title-len').textContent=this.value.length">
                        </div>
                        <div class="form-group">
                            <label>Title Separator</label>
                            <input type="text" name="title_separator" maxlength="10"
                                   value="{{ old('title_separator', $seo->title_separator ?? '—') }}" class="form-control"
                                   placeholder="—">
                            <small class="form-hint">e.g. — | •</small>
                        </div>
                    </div>
                    <small class="form-hint"><span id="title-len">{{ strlen($seo->default_title ?? '') }}</span>/160 characters</small>

                    <div class="form-group" style="margin-top:1rem;">
                        <label>Default Meta Description</label>
                        <textarea name="default_description" rows="3" maxlength="320"
                                  class="form-control"
                                  placeholder="Pakistan's most curated luxury beauty destination…"
                                  oninput="document.getElementById('desc-len').textContent=this.value.length">{{ old('default_description', $seo->default_description) }}</textarea>
                        <small class="form-hint"><span id="desc-len">{{ strlen($seo->default_description ?? '') }}</span>/320 — Recommended 120–160 chars</small>
                    </div>

                    <div class="form-group">
                        <label>Default Keywords</label>
                        <input type="text" name="default_keywords" maxlength="255"
                               value="{{ old('default_keywords', $seo->default_keywords) }}" class="form-control"
                               placeholder="beauty, cosmetics, skincare, makeup, Pakistan">
                    </div>

                    <div class="form-group">
                        <label>Canonical Base URL</label>
                        <input type="url" name="canonical_base_url" maxlength="255"
                               value="{{ old('canonical_base_url', $seo->canonical_base_url) }}" class="form-control"
                               placeholder="https://www.bharkabeauty.com">
                        <small class="form-hint">Used to build canonical tags. Leave empty to use APP_URL.</small>
                    </div>

                </div>

                {{-- ── Open Graph ── --}}
                <div class="seo-panel admin-form" id="tab-opengraph">

                    <div class="form-group">
                        <label>Default OG Image <span class="form-hint">Shown when page is shared on social media</span></label>
                        @if($seo->og_image_url)
                            <div style="margin-bottom:.75rem;">
                                <img src="{{ $seo->og_image_url }}" style="max-height:120px;border-radius:8px;object-fit:cover;">
                            </div>
                        @endif
                        <input type="file" name="og_image" accept="image/*" class="form-control">
                        <small class="form-hint">Recommended: 1200×630px. Used as fallback for all pages without a specific OG image.</small>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group">
                            <label>OG Type</label>
                            <select name="og_type" class="form-control">
                                @foreach(['website' => 'website', 'article' => 'article', 'product' => 'product'] as $v => $l)
                                    <option value="{{ $v }}" {{ old('og_type', $seo->og_type) === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Twitter Card Type</label>
                            <select name="twitter_card" class="form-control">
                                <option value="summary_large_image" {{ old('twitter_card', $seo->twitter_card) === 'summary_large_image' ? 'selected' : '' }}>Large Image</option>
                                <option value="summary"             {{ old('twitter_card', $seo->twitter_card) === 'summary' ? 'selected' : '' }}>Summary</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Twitter / X Handle</label>
                        <input type="text" name="twitter_site" maxlength="80"
                               value="{{ old('twitter_site', $seo->twitter_site) }}" class="form-control"
                               placeholder="@bharkabeauty">
                        <small class="form-hint">Include the @ symbol.</small>
                    </div>

                </div>

                {{-- ── Analytics ── --}}
                <div class="seo-panel admin-form" id="tab-analytics">
                    <div class="alert" style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:.875rem 1rem;color:#0369a1;margin-bottom:1.5rem;font-size:.875rem;">
                        Tracking codes are injected automatically — no plugin needed.
                    </div>

                    <div class="form-group">
                        <label>Google Analytics 4 (Measurement ID)</label>
                        <input type="text" name="google_analytics_id" maxlength="60"
                               value="{{ old('google_analytics_id', $seo->google_analytics_id) }}" class="form-control"
                               placeholder="G-XXXXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Google Tag Manager (Container ID)</label>
                        <input type="text" name="google_tag_manager_id" maxlength="60"
                               value="{{ old('google_tag_manager_id', $seo->google_tag_manager_id) }}" class="form-control"
                               placeholder="GTM-XXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Facebook Pixel ID</label>
                        <input type="text" name="facebook_pixel_id" maxlength="60"
                               value="{{ old('facebook_pixel_id', $seo->facebook_pixel_id) }}" class="form-control"
                               placeholder="1234567890123456">
                    </div>
                </div>

                {{-- ── Code Injection ── --}}
                <div class="seo-panel admin-form" id="tab-scripts">
                    <div class="alert" style="background:#fef9c3;border:1px solid #fde047;border-radius:8px;padding:.875rem 1rem;color:#713f12;margin-bottom:1.5rem;font-size:.875rem;">
                        ⚠ Only paste trusted code here. Malicious scripts can compromise your entire site.
                    </div>

                    <div class="form-group">
                        <label>Custom &lt;head&gt; Code</label>
                        <textarea name="custom_head_code" rows="8" class="form-control"
                                  style="font-family:monospace;font-size:.85rem;"
                                  placeholder="<!-- Injected before </head> -->">{{ old('custom_head_code', $seo->custom_head_code) }}</textarea>
                        <small class="form-hint">Inserted before &lt;/head&gt;. Useful for verification tags, custom fonts, etc.</small>
                    </div>

                    <div class="form-group">
                        <label>Custom &lt;body&gt; Code</label>
                        <textarea name="custom_body_code" rows="8" class="form-control"
                                  style="font-family:monospace;font-size:.85rem;"
                                  placeholder="<!-- Injected before </body> -->">{{ old('custom_body_code', $seo->custom_body_code) }}</textarea>
                        <small class="form-hint">Inserted before &lt;/body&gt;. Useful for chat widgets, analytics fallbacks, etc.</small>
                    </div>
                </div>

                {{-- ── Robots.txt ── --}}
                <div class="seo-panel admin-form" id="tab-robots">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                        <label style="margin:0;">robots.txt Content</label>
                        <a href="/robots.txt" target="_blank" class="btn btn-outline btn-sm">View Live →</a>
                    </div>
                    <textarea name="robots_txt" rows="14" class="form-control"
                              style="font-family:monospace;font-size:.875rem;"
                              placeholder="User-agent: *&#10;Allow: /&#10;Disallow: /admin/&#10;&#10;Sitemap: {{ url('/sitemap.xml') }}">{{ old('robots_txt', $seo->robots_txt) }}</textarea>
                    <small class="form-hint">
                        Served at <a href="/robots.txt" target="_blank" style="color:#c9a96e;">/robots.txt</a>. Leave empty for the default rule.
                    </small>

                    <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f0e8da;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <label style="margin:0;font-weight:600;">XML Sitemap</label>
                            <a href="/sitemap.xml" target="_blank" class="btn btn-outline btn-sm">View Live →</a>
                        </div>
                        <p style="font-size:.85rem;color:#6b7280;margin:.5rem 0 0;">
                            Your sitemap is auto-generated at <a href="/sitemap.xml" target="_blank" style="color:#c9a96e;">/sitemap.xml</a> and includes all published blog posts, services, and CMS pages.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Save Sidebar --}}
        <div>
            <div class="admin-card" style="position:sticky;top:90px;">
                <div class="admin-card-header"><h3 class="admin-card-title">Save</h3></div>
                <div style="padding:1rem;">
                    <button type="submit" class="btn btn-primary btn-full">Save SEO Settings</button>
                    <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #f0e8da;">
                        <p style="font-size:.8rem;color:#6b7280;margin:0 0 .5rem;">Quick Links</p>
                        <a href="{{ route('home') }}" target="_blank" style="font-size:.82rem;color:#c9a96e;display:block;margin-bottom:.3rem;">View Homepage →</a>
                        <a href="/sitemap.xml" target="_blank" style="font-size:.82rem;color:#c9a96e;display:block;margin-bottom:.3rem;">XML Sitemap →</a>
                        <a href="/robots.txt" target="_blank" style="font-size:.82rem;color:#c9a96e;display:block;">Robots.txt →</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.seo-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.seo-tab, .seo-panel').forEach(el => el.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
