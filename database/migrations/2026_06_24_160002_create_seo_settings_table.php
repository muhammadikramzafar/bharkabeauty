<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('title_separator', 10)->default('—');
            $table->string('default_title')->nullable();
            $table->text('default_description')->nullable();
            $table->string('default_keywords')->nullable();
            $table->string('og_image')->nullable();       // stored file path
            $table->string('og_type', 40)->default('website');
            $table->string('twitter_card', 40)->default('summary_large_image');
            $table->string('twitter_site', 80)->nullable();   // @handle
            $table->string('google_analytics_id', 60)->nullable();
            $table->string('google_tag_manager_id', 60)->nullable();
            $table->string('facebook_pixel_id', 60)->nullable();
            $table->text('custom_head_code')->nullable();
            $table->text('custom_body_code')->nullable();
            $table->text('robots_txt')->nullable();
            $table->string('canonical_base_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('seo_settings'); }
};
