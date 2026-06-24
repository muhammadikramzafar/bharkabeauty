<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homepage_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name');
            $table->string('reviewer_location')->nullable();
            $table->text('review_text');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('reviewer_image')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_testimonials');
    }
};
