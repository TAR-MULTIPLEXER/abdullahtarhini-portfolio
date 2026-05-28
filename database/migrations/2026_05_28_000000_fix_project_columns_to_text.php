<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Change these columns to TEXT to support large Base64 strings
            if (Schema::hasColumn('projects', 'cover_image_data')) {
                $table->text('cover_image_data')->change();
            }
            
            if (Schema::hasColumn('projects', 'image_details')) {
                $table->text('image_details')->change();
            }

            if (Schema::hasColumn('projects', 'pdfs')) {
                $table->text('pdfs')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'cover_image_data')) {
                $table->string('cover_image_data', 255)->change();
            }
            
            if (Schema::hasColumn('projects', 'image_details')) {
                $table->string('image_details', 255)->change();
            }

            if (Schema::hasColumn('projects', 'pdfs')) {
                $table->string('pdfs', 255)->change();
            }
        });
    }
};