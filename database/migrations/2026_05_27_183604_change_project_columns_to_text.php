<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Change columns that store large data to TEXT type
            $table->text('short_description')->change();
            $table->text('full_description')->change();
            $table->text('gallery_description')->change();
            $table->text('cover_image')->change();      // For base64 data
            $table->text('image_details')->change();     // For base64 data
            $table->text('pdfs')->nullable()->change();  // If storing base64
            $table->text('tools_used')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert to varchar(255) if needed
            $table->string('short_description')->change();
            $table->string('full_description')->change();
            $table->string('gallery_description')->change();
            $table->string('cover_image')->change();
            $table->string('image_details')->change();
            $table->string('pdfs')->nullable()->change();
            $table->string('tools_used')->nullable()->change();
        });
    }
};