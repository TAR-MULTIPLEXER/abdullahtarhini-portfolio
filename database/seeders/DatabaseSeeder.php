<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a default admin user if it doesn't exist
        User::updateOrCreate(
            ['email' => 'abdullahtarhini55@gmail.com'],
            [
                'name' => 'Abdullah Tarhini',
                'password' => Hash::make('communication41730076'), // CHANGE THIS to your desired password
            ]
        );
    }
}