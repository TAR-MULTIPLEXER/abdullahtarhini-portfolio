<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

// Test Route for Laravel Uploads
Route::match(['get', 'post'], '/laravel-upload-test', function (Request $request) {
    $message = '';
    $type = '';

    if ($request->isMethod('post')) {
        // 1. Check Session
        $sessionId = session()->getId();
        
        // 2. Check CSRF
        $csrfValid = $request->hasSession() && $request->session()->token() === $request->input('_token');

        // 3. Handle File
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            
            try {
                // Try to store it using Laravel's Storage facade
                $path = $file->store('test-uploads', 'public');
                
                if ($path) {
                    $message = "✅ SUCCESS! File stored at: storage/app/public/" . $path;
                    $type = 'success';
                } else {
                    $message = "❌ FAILED: Storage::put returned false.";
                    $type = 'error';
                }
            } catch (\Exception $e) {
                $message = "❌ EXCEPTION: " . $e->getMessage();
                $type = 'error';
            }
        } else {
            $message = "⚠️ No file received in POST request.";
            $type = 'warning';
        }

        // Debug Info
        $debug = [
            'Session ID' => $sessionId,
            'CSRF Valid' => $csrfValid ? 'YES' : 'NO',
            'POST Data Size' => strlen(file_get_contents('php://input')),
            'Files Count' => count($request->allFiles()),
        ];
    }

    return view('upload-test', compact('message', 'type', 'debug'));
})->name('laravel-upload-test');