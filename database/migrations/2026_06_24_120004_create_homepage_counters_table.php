<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homepage_counters', function (Blueprint $table) {
            $table->id();
            $table->string('number');           // "200", "50,000"
            $table->string('suffix')->nullable(); // "+", "%", "K+"
            $table->string('label');            // "Premium Brands"
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_counters');
    }
};
