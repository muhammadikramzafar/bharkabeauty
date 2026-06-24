<!-- ─── NEWSLETTER ─────────────────────────────────────────── -->
<section class="newsletter-section" aria-labelledby="newsletter-heading">
    <h2 class="newsletter-title" id="newsletter-heading">Join the BharkaBeauty Family</h2>
    <p class="newsletter-sub">Sign up for exclusive previews, beauty tips, and member-only offers.</p>
    <form class="newsletter-form" id="newsletter-form" novalidate>
        @csrf
        <input class="newsletter-input" type="email" placeholder="Email Address" aria-label="Email address" required />
        <button class="newsletter-btn" type="submit">Subscribe</button>
    </form>
</section>

<!-- ─── FOOTER ─────────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
    <div class="footer-main">
        <div class="footer-brand">
            <p class="footer-brand-logo">Bharka<span>Beauty</span></p>
            <p class="footer-brand-desc">Premium luxury cosmetics and skincare retailer, curated for beauty rituals across Pakistan. Discover the essence of elegance.</p>
            <div class="footer-social">
                <a href="#" class="social-btn" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="#" class="social-btn" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </a>
                <a href="#" class="social-btn" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                </a>
                <a href="#" class="social-btn" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.97C18.88 4 12 4 12 4s-6.88 0-8.59.45A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.58C5.12 20 12 20 12 20s6.88 0 8.59-.42a2.78 2.78 0 001.95-1.97A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                </a>
            </div>
        </div>

        <div class="footer-col">
            <p class="footer-col-title">Shop</p>
            <nav class="footer-links" aria-label="Shop links">
                <a href="{{ route('category.index', ['cat' => 'makeup']) }}"    class="footer-link">Makeup</a>
                <a href="{{ route('category.index', ['cat' => 'skincare']) }}"  class="footer-link">Skincare</a>
                <a href="{{ route('category.index', ['cat' => 'haircare']) }}"  class="footer-link">Haircare</a>
                <a href="{{ route('category.index', ['cat' => 'fragrance']) }}" class="footer-link">Fragrances</a>
            </nav>
        </div>

        <div class="footer-col">
            <p class="footer-col-title">Company</p>
            <nav class="footer-links" aria-label="Company links">
                <a href="{{ route('about') }}"   class="footer-link">About Us</a>
                <a href="{{ route('brands') }}"  class="footer-link">Brands</a>
                <a href="#"                      class="footer-link">Careers</a>
                <a href="{{ route('contact') }}" class="footer-link">Contact</a>
            </nav>
        </div>

        <div class="footer-col">
            <p class="footer-col-title">Support</p>
            <nav class="footer-links" aria-label="Support links">
                <a href="#" class="footer-link">FAQ</a>
                <a href="#" class="footer-link">Shipping Policy</a>
                <a href="#" class="footer-link">Returns</a>
                <a href="#" class="footer-link">Track Order</a>
            </nav>
        </div>

        <div class="footer-col">
            <p class="footer-col-title">Legal</p>
            <nav class="footer-links" aria-label="Legal links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Use</a>
                <a href="#" class="footer-link">Cookie Policy</a>
                <a href="#" class="footer-link">Sitemap</a>
            </nav>
        </div>
    </div>

    <div class="footer-bottom">
        <p class="footer-copy">© {{ date('Y') }} BharkaBeauty. All rights reserved.</p>
        <div class="footer-delivery">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
            </svg>
            <span>Delivering beauty across Pakistan</span>
        </div>
    </div>
</footer>
