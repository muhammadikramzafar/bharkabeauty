<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeSetting;
use App\Models\HeroSlide;
use App\Models\HomepageService;
use App\Models\HomepageCounter;
use App\Models\HomepageTestimonial;
use App\Models\HomepageFeatured;
use App\Models\HomepageLogo;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // Settings with defaults
        HomeSetting::instance()->update([
            'flash_sale_title'    => 'Flash Sale',
            'flash_sale_subtitle' => 'Exclusive deals on your favorites. Ending soon!',
            'flash_sale_end'      => now()->addHours(12),
            'show_flash_sale'     => true,
            'store_title'         => 'Visit Our Flagship Store',
            'store_description'   => 'Experience our curated luxury collection in person. Expert consultations and exclusive in-store shades await you.',
            'store_address'       => 'DHA Phase 6, Lahore, Pakistan',
            'store_hours'         => 'Open Mon–Sat: 10:00 AM – 9:00 PM',
            'store_button_text'   => 'Find Our Store',
            'store_button_url'    => '/store-locator',
            'newsletter_title'    => 'Stay in the Loop',
            'newsletter_subtitle' => 'Get exclusive offers, new arrivals, and beauty tips delivered to your inbox.',
            'seo_title'           => 'BharkaBeauty — Premium Luxury Cosmetics & Skincare Pakistan',
            'seo_description'     => 'Pakistan\'s most curated luxury beauty destination. Shop premium cosmetics, skincare, and haircare from top global brands.',
            'seo_keywords'        => 'beauty, cosmetics, skincare, makeup, Pakistan, luxury beauty',
            'show_hero'           => true,
            'show_categories'     => true,
            'show_brands'         => true,
            'show_featured'       => true,
            'show_about'          => false,
            'show_services'       => true,
            'show_counters'       => true,
            'show_testimonials'   => true,
            'show_store_cta'      => true,
            'show_newsletter'     => true,
        ]);

        // Hero Slides
        if (!HeroSlide::count()) {
            HeroSlide::insert([
                ['eyebrow' => 'New Season, New Glow', 'title' => 'Your Beauty,', 'title_highlight' => 'Our Craft', 'description' => 'Pakistan\'s most curated luxury beauty destination — premium cosmetics, skincare rituals, and expert-approved picks delivered to your door.', 'badge_text' => 'Premium Beauty Collections', 'button1_text' => 'Shop Now', 'button1_url' => '/shop', 'button2_text' => 'Explore Brands', 'button2_url' => '/brands', 'sort_order' => 0, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['eyebrow' => 'Summer Collection', 'title' => 'Glow All', 'title_highlight' => 'Season Long', 'description' => 'Discover our curated summer essentials — SPF, tinted moisturizers, and dewy finishes for Pakistan\'s sun-kissed days.', 'badge_text' => 'Summer Essentials', 'button1_text' => 'Shop Summer', 'button1_url' => '/shop?col=summer', 'button2_text' => 'See Skincare', 'button2_url' => '/shop?cat=skincare', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['eyebrow' => 'New Arrivals Weekly', 'title' => 'Fresh Drops,', 'title_highlight' => 'Every Week', 'description' => 'Be the first to discover new beauty arrivals — from global cult favorites to local hero products.', 'badge_text' => 'New This Week', 'button1_text' => 'New Arrivals', 'button1_url' => '/shop?col=new', 'button2_text' => 'Trending Now', 'button2_url' => '/shop?col=trending', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Service Highlights
        if (!HomepageService::count()) {
            $services = [
                ['emoji' => '✅', 'title' => '100% Authentic', 'description' => 'Every product is genuine and sourced directly from authorized distributors.'],
                ['emoji' => '🚚', 'title' => 'Free Delivery', 'description' => 'Free shipping on orders over PKR 2,500 across Pakistan.'],
                ['emoji' => '🔄', 'title' => 'Easy Returns', 'description' => '7-day hassle-free returns on all unopened products.'],
                ['emoji' => '💳', 'title' => 'Secure Payment', 'description' => 'Multiple payment options including COD, card, and EasyPaisa.'],
            ];
            foreach ($services as $i => $s) {
                HomepageService::create(['icon' => $s['emoji'], 'icon_type' => 'emoji', 'title' => $s['title'], 'description' => $s['description'], 'sort_order' => $i, 'is_active' => true]);
            }
        }

        // Counters
        if (!HomepageCounter::count()) {
            $counters = [
                ['number' => '200',    'suffix' => '+',  'label' => 'Premium Brands',    'description' => 'Global & local'],
                ['number' => '50,000', 'suffix' => '+',  'label' => 'Happy Customers',   'description' => 'Across Pakistan'],
                ['number' => '10,000', 'suffix' => '+',  'label' => 'Products',          'description' => 'In our catalog'],
                ['number' => '4.9',    'suffix' => '/5', 'label' => 'Average Rating',    'description' => 'From 8,000+ reviews'],
            ];
            foreach ($counters as $i => $c) {
                HomepageCounter::create(array_merge($c, ['sort_order' => $i, 'is_active' => true]));
            }
        }

        // Testimonials
        if (!HomepageTestimonial::count()) {
            $testimonials = [
                ['reviewer_name' => 'Ayesha Khan', 'reviewer_location' => 'Lahore', 'review_text' => 'The quality is absolutely amazing. I\'ve been buying from BharkaBeauty for 2 years and they never disappoint. Fast delivery and 100% authentic products!', 'rating' => 5, 'product_brand' => 'Huda Beauty', 'product_name' => 'Rose Gold Palette'],
                ['reviewer_name' => 'Sara Ahmed', 'reviewer_location' => 'Karachi', 'review_text' => 'Best skincare shopping experience in Pakistan. The packaging is beautiful and products arrive in perfect condition. Highly recommend!', 'rating' => 5, 'product_brand' => 'The Ordinary', 'product_name' => 'Niacinamide 10%'],
                ['reviewer_name' => 'Fatima Malik', 'reviewer_location' => 'Islamabad', 'review_text' => 'I love that they carry brands I can\'t find anywhere else in Pakistan. Customer service is also top-notch — they helped me find the perfect foundation shade!', 'rating' => 5, 'product_brand' => 'Maybelline', 'product_name' => 'Fit Me Foundation'],
            ];
            foreach ($testimonials as $i => $t) {
                HomepageTestimonial::create(array_merge($t, ['sort_order' => $i, 'is_active' => true]));
            }
        }

        // Featured Collections
        if (!HomepageFeatured::count()) {
            $collections = [
                ['eyebrow' => 'Collection', 'title' => 'Best Sellers', 'description' => 'Our most-loved products, tried and tested by thousands of beauty lovers across Pakistan.', 'button_text' => 'Shop Best Sellers', 'button_url' => '/shop?col=bestsellers'],
                ['eyebrow' => 'New In',     'title' => 'New Arrivals', 'description' => 'Fresh drops of the latest skincare, makeup and more — be the first to explore.',           'button_text' => 'Shop New Arrivals', 'button_url' => '/shop?col=new'],
                ['eyebrow' => 'Trending',   'title' => 'Trending Now', 'description' => 'What beauty lovers are obsessing over right now — get on trend before it sells out.',      'button_text' => 'Shop Trending',     'button_url' => '/shop?col=trending'],
            ];
            foreach ($collections as $i => $c) {
                HomepageFeatured::create(array_merge($c, ['sort_order' => $i, 'is_active' => true]));
            }
        }

        // Brand Logos
        if (!HomepageLogo::count()) {
            $brands = [
                ['name' => 'Maybelline', 'tagline' => 'Makeup',   'url' => '/shop?brand=maybelline'],
                ['name' => "L'Oréal Paris", 'tagline' => 'Makeup','url' => '/shop?brand=loreal'],
                ['name' => 'Garnier',    'tagline' => 'Skincare',  'url' => '/shop?brand=garnier'],
                ['name' => 'Neutrogena', 'tagline' => 'Skincare',  'url' => '/shop?brand=neutrogena'],
                ['name' => 'The Ordinary','tagline'=> 'Skincare',  'url' => '/shop?brand=ordinary'],
                ['name' => 'CeraVe',     'tagline' => 'Skincare',  'url' => '/shop?brand=cerave'],
                ['name' => 'Huda Beauty','tagline' => 'Makeup',    'url' => '/shop?brand=huda'],
                ['name' => 'Essence',    'tagline' => 'Makeup',    'url' => '/shop?brand=essence'],
                ['name' => 'Rivaj UK',   'tagline' => 'Makeup',    'url' => '/shop?brand=rivaj'],
            ];
            foreach ($brands as $i => $b) {
                HomepageLogo::create(array_merge($b, ['sort_order' => $i, 'is_active' => true]));
            }
        }
    }
}
