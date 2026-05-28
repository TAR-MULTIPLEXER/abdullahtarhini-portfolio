<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Change cover_image to TEXT (unlimited length for base64)
            if (Schema::hasColumn('projects', 'cover_image')) {
                $table->text('cover_image')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'cover_image')) {
                $table->string('cover_image', 255)->change();
            }
        });
    }
};