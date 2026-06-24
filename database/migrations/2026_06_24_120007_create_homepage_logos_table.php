<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homepage_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();   // "Makeup", "Skincare"
            $table->string('logo')->nullable();       // uploaded logo image
            $table->string('url')->nullable();        // click-through URL
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_logos');
    }
};
