<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

Route::get('/debug-upload', function () {
    try {
        // Test 1: Is the disk writable?
        Storage::disk('public')->put('test.txt', 'ok');
        $read = Storage::disk('public')->get('test.txt');
        Storage::disk('public')->delete('test.txt');

        // Test 2: Is the session alive?
        $session = session()->getId();

        // Test 3: Force Laravel to log what Livewire sees
        Log::info('DEBUG: Storage OK, Session ID: ' . $session);

        return response()->json([
            'status' => '✅ SUCCESS',
            'storage_writable' => true,
            'session_id' => $session,
            'last_laravel_log' => file_get_contents(storage_path('logs/laravel.log')) ?? 'No logs found',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => '❌ FAILED',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }
});