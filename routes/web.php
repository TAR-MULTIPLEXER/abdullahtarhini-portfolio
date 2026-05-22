<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Livewire\Features\SupportFileUploads\FileUploadController;

// ✅ CRITICAL FIX: Explicitly define Livewire upload route with 'web' middleware
// This ensures Session and CSRF tokens are correctly handled for uploads
Route::post('/livewire/upload-file', [FileUploadController::class, 'handle'])
    ->middleware('web')
    ->name('livewire.upload-file');

// Your Existing Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/create-admin', function () {
    $user = User::updateOrCreate(
        ['email' => 'abdullahtarhini55@gmail.com'],
        [
            'name' => 'Abdullah Tarhini',
            'password' => Hash::make('communication41730076'), 
        ]
    );
    return 'Admin user created/updated successfully!';
});

Route::get('/project/{slug}', [HomeController::class, 'show'])->name('project.show');