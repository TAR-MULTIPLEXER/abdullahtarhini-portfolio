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
        $table->string('image_details', 5000)->change(); // or use ->text() for unlimited
        // Repeat for any other columns that need more space
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
