<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            
            // Project Type
            $table->enum('type', ['web', 'hardware', 'desktop', 'telecom'])->default('web');
            
            // Category & Status
            $table->string('category');
            $table->enum('status', ['completed', 'ongoing', 'academic'])->default('completed');
            
            // Descriptions
            $table->text('short_description');
            $table->longText('full_description');
            
            // Media
            $table->json('images')->nullable();
            $table->string('video_url')->nullable();
            $table->string('diagram_url')->nullable();
            
            // Links
            $table->string('github_link')->nullable();
            $table->string('live_link')->nullable();
            $table->string('documentation_link')->nullable();
            
            // Hardware Specs
            $table->json('specifications')->nullable();
            $table->string('tools_used')->nullable();
            
            // Metadata
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};