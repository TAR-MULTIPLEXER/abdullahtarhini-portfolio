<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Use TEXT for columns storing base64/large content
            $table->text('cover_image')->change();
            $table->text('image_details')->change();
            $table->text('pdfs')->nullable()->change();
            
            // Also ensure description fields can handle HTML content
            $table->text('full_description')->change();
            $table->text('gallery_description')->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert if needed (not recommended if data exists)
            $table->string('cover_image', 255)->change();
            $table->string('image_details', 255)->change();
            $table->string('pdfs', 255)->nullable()->change();
            $table->string('full_description', 255)->change();
            $table->string('gallery_description', 255)->change();
        });
    }
};