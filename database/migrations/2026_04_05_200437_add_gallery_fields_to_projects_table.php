<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('image_details')->nullable()->after('images');
            $table->text('gallery_description')->nullable()->after('full_description');
            $table->boolean('show_gallery_description')->default(true)->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['image_details', 'gallery_description', 'show_gallery_description']);
        });
    }
};