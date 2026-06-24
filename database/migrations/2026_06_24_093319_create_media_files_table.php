<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // display name
            $table->string('file_name');                   // stored filename
            $table->string('path');                        // storage path
            $table->string('url');                         // public URL
            $table->string('mime_type');
            $table->string('type')->default('image');      // image | video | pdf | document
            $table->unsignedBigInteger('size')->default(0); // bytes
            $table->string('alt_text')->nullable();
            $table->string('disk')->default('public');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
