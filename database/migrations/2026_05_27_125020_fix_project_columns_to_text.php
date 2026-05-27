<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
{
    Schema::table('projects', function (Blueprint $table) {
        // Change cover_image_data to TEXT (unlimited length)
        if (Schema::hasColumn('projects', 'cover_image_data')) {
            $table->text('cover_image_data')->change();
        }
        
        // Change image_details to TEXT (to store JSON of Base64 images)
        if (Schema::hasColumn('projects', 'image_details')) {
            $table->text('image_details')->change();
        }

        // Change pdfs to TEXT just in case
        if (Schema::hasColumn('projects', 'pdfs')) {
            $table->text('pdfs')->change();
        }
    });
}

public function down(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->string('cover_image_data', 255)->change();
        $table->string('image_details', 255)->change();
        $table->string('pdfs', 255)->change();
    });
}
};
