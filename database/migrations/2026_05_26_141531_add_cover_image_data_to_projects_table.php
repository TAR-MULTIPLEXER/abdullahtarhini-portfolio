<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->longText('cover_image_data')->nullable()->after('cover_image');
    });
}

public function down(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn('cover_image_data');
    });
}
};
