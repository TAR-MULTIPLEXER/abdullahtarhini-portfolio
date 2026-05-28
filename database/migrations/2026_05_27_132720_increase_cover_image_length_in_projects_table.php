<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// In the migration file
public function up(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->text('cover_image')->change();
        $table->text('image_details')->change(); // if you store images here too
        $table->text('pdfs')->change(); // if you store base64 files here too
    });
}

public function down(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->string('cover_image', 255)->change();
        $table->string('image_details', 255)->change();
        $table->string('pdfs', 255)->change();
    });
}
};
