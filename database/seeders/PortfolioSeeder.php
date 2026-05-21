<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Create a default admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'abdullahtarhini55@gmail.com',
            'password' => Hash::make('communication41730076'), 
        ]);

        // Add sample projects (customize as needed)
        Project::create([
            'title' => 'Sample Project',
            'description' => 'This is a sample project description.',
            'image' => 'default-project.jpg',
            'is_featured' => true,
            'sort_order' => 1,
        ]);
    }
}