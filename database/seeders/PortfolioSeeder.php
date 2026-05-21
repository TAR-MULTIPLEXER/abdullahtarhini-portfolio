<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ONLY Create Admin User. No projects.
        User::updateOrCreate(
            ['email' => 'abdullahtarhini55@gmail.com'],
            [
                'name' => 'Abdullah Tarhini',
                'password' => Hash::make('communication41730076'), 
            ]
        );
    }
}