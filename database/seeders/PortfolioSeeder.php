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
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'abdullahtarhini55@gmail.com'],
            [
                'name' => 'Abdullah Tarhini',
                'password' => Hash::make('communication41730076'), 
            ]
        );

        // 2. Create Sample Project (Only use 'title' to avoid column errors)
        // We will add other details via the Admin Panel later once you login!
        Project::updateOrCreate(
            ['title' => 'Sample Project'],
            [
                // Leave other fields empty for now to prevent crashes
            ]
        );
    }
}