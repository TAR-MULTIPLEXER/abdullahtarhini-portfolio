<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Use raw SQL to force the cast from text to json
            DB::statement('ALTER TABLE projects ALTER COLUMN image_details TYPE json USING image_details::json');
            
            // Ensure it is nullable after the type change
            $table->json('image_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert back to text if needed
            DB::statement('ALTER TABLE projects ALTER COLUMN image_details TYPE text USING image_details::text');
            $table->text('image_details')->nullable()->change();
        });
    }
};