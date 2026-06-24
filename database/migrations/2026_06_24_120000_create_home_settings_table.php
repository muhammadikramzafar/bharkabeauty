<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();

            // Flash Sale
            $table->string('flash_sale_title')->default('Flash Sale');
            $table->string('flash_sale_subtitle')->default('Exclusive deals on your favorites. Ending soon!');
            $table->dateTime('flash_sale_end')->nullable();
            $table->boolean('show_flash_sale')->default(true);

            // About Section
            $table->string('about_eyebrow')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about_button_text')->nullable();
            $table->string('about_button_url')->nullable();

            // Flagship Store CTA
            $table->string('store_title')->default('Visit Our Flagship Store');
            $table->text('store_description')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_hours')->nullable();
            $table->string('store_image')->nullable();
            $table->string('store_button_text')->default('Find Our Store');
            $table->string('store_button_url')->nullable();

            // Newsletter CTA
            $table->string('newsletter_title')->default('Stay in the Loop');
            $table->string('newsletter_subtitle')->nullable();

            // Section visibility toggles
            $table->boolean('show_hero')->default(true);
            $table->boolean('show_categories')->default(true);
            $table->boolean('show_brands')->default(true);
            $table->boolean('show_featured')->default(true);
            $table->boolean('show_about')->default(false);
            $table->boolean('show_services')->default(true);
            $table->boolean('show_counters')->default(true);
            $table->boolean('show_testimonials')->default(true);
            $table->boolean('show_store_cta')->default(true);
            $table->boolean('show_newsletter')->default(true);

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
