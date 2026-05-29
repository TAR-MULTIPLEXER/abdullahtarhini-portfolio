<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Change the column to be nullable
            $table->text('gallery_description')->nullable()->change();
            
            // While we are here, let's ensure cover_image_data and image_details are also nullable 
            // to prevent similar errors for those fields
            $table->text('cover_image_data')->nullable()->change();
            $table->json('image_details')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('gallery_description')->nullable(false)->change();
            $table->text('cover_image_data')->nullable(false)->change();
            $table->json('image_details')->nullable(false)->change();
        });
    }
};