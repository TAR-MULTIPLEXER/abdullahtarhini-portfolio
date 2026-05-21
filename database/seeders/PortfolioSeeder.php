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
        // 1. Create Admin User (This is all we need for login)
        User::updateOrCreate(
            ['email' => 'abdullahtarhini55@gmail.com'],
            [
                'name' => 'Abdullah Tarhini',
                'password' => Hash::make('communication41730076'), 
            ]
        );

        // 2. Create a Simple Project (No image for now to prevent crashes)
        Project::updateOrCreate(
            ['title' => 'Sample Project'],
            [
                'description' => 'This is a sample project.',
                'image' => null, // Set to null temporarily
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );
    }
}