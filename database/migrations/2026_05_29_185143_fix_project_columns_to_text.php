<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw SQL to force the column type change to TEXT (unlimited size)
        // This works on PostgreSQL without needing Doctrine/DBAL
        
        if (Schema::hasColumn('projects', 'cover_image')) {
            DB::statement('ALTER TABLE projects ALTER COLUMN cover_image TYPE TEXT;');
        }
        
        if (Schema::hasColumn('projects', 'image_details')) {
            DB::statement('ALTER TABLE projects ALTER COLUMN image_details TYPE TEXT;');
        }
        
        if (Schema::hasColumn('projects', 'pdfs')) {
            DB::statement('ALTER TABLE projects ALTER COLUMN pdfs TYPE TEXT;');
        }
    }

    public function down(): void
    {
        // You can leave this empty
    }
};