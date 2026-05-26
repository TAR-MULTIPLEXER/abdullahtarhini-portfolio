<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    \App\Models\Project::create([
        'title' => 'Test Project',
        'slug' => 'test-project',
        'type' => 'web',
        'category' => 'Portfolio',
        'status' => 'completed',
        'short_description' => 'A test project to verify DB.',
        'full_description' => 'Full details here.',
        'cover_image' => null, // Leave null for now
    ]);
}
}
