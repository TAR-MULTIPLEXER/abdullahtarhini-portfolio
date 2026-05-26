<?php

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
Route::get('/fix-sessions', function () {
    try {
        // Create sessions table if it doesn't exist
        \Illuminate\Support\Facades\Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
        // Clear caches
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        return '✅ Sessions table created + caches cleared! <a href="/admin/login">Try Login</a>';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Project Show Page
Route::get('/project/{slug}', [HomeController::class, 'show'])->name('project.show');

// Create Admin Route
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

// ===== TEMPORARY: DATABASE IMPORT (With CSRF) =====

Route::get('/db-upload-form', function () {
    $csrf = csrf_token();
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Import Database</title>
        <style>
            body { font-family: sans-serif; padding: 40px; background: #f5f5f5; }
            .card { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
            h1 { margin-bottom: 20px; color: #333; }
            input[type="file"] { width: 100%; padding: 10px; margin: 15px 0; border: 2px solid #e0e0e0; border-radius: 8px; }
            button { background: #4F46E5; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 16px; cursor: pointer; }
            button:hover { background: #4338CA; }
            .warning { background: #fff3cd; color: #856404; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffeeba; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>📦 Import Database</h1>
            <div class="warning">⚠️ Warning: This will overwrite your production database!</div>
            <form method="POST" enctype="multipart/form-data" action="/db-import">
                <input type="hidden" name="_token" value="$csrf">
                <label><strong>Select your local database.sqlite file:</strong></label>
                <input type="file" name="db_file" accept=".sqlite" required>
                <button type="submit">🚀 Upload & Import</button>
            </form>
        </div>
    </body>
    </html>
    HTML;
});

Route::post('/db-import', function (Request $request) {
    if ($request->hasFile('db_file')) {
        $file = $request->file('db_file');
        $destination = database_path('database.sqlite');
        
        // Backup old DB just in case
        if (File::exists($destination)) {
            File::copy($destination, database_path('database_backup.sqlite'));
        }
        
        // Move new DB
        $file->move(database_path(), 'database.sqlite');
        
        // ✅ FIX PERMISSIONS - This is the critical step!
        chmod($destination, 0664);
        chown($destination, 'www-data');
        chgrp($destination, 'www-data');
        
        // Also fix the entire database folder
        $dbDir = database_path();
        chmod($dbDir, 0775);
        chown($dbDir, 'www-data');
        chgrp($dbDir, 'www-data');
        
        return '✅ Database imported successfully! <a href="/">Refresh your site</a>.';
    }
    return '❌ No file uploaded. <a href="/db-upload-form">Go back</a>.';
});

// ===== OPTIONAL: SIMPLE UPLOAD TEST (Raw DB) =====
// You can delete these if you don't need them right now

Route::get('/test-upload-page', function () {
    $uploads = \Illuminate\Support\Facades\DB::table('projects')
        ->whereNotNull('cover_image')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    return view('test-upload', compact('uploads'));
});

Route::post('/test-upload-page', function (Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
        'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);
    
    try {
        $file = $request->file('cover_image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/projects/covers');
        
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        
        if ($file->move($destinationPath, $filename)) {
            $imagePath = 'projects/covers/' . $filename;
            
            \Illuminate\Support\Facades\DB::table('projects')->insertGetId([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'cover_image' => $imagePath,
                'type' => 'web',
                'category' => 'Test',
                'status' => 'completed',
                'short_description' => 'Test upload',
                'full_description' => 'Test upload description',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return back()->with('success', "✅ Upload successful!");
        }
        return back()->with('error', '❌ Failed to move file');
    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
})->name('test.upload');
Route::get('/debug-db', function () {
    try {
        $count = \App\Models\Project::count();
        $sample = \App\Models\Project::first();
        $dbPath = database_path('database.sqlite');
        $perms = substr(sprintf('%o', fileperms($dbPath)), -4);
        
        return "
        <h1>✅ Database OK</h1>
        <p><strong>Projects:</strong> $count</p>
        <p><strong>Sample:</strong> " . ($sample ? $sample->title : 'None') . "</p>
        <p><strong>DB Path:</strong> $dbPath</p>
        <p><strong>Permissions:</strong> $perms</p>
        <p><a href='/'>← Home</a></p>
        ";
    } catch (\Exception $e) {
        return "<h1>❌ Database Error</h1><pre>" . $e->getMessage() . "</pre>";
    }
});
// ===== TEMPORARY: RUN MIGRATIONS ROUTE =====
Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return "<h1>✅ Migrations Run</h1><pre>" . htmlspecialchars($output) . "</pre><p><a href='/'>← Home</a></p>";
    } catch (\Exception $e) {
        return "<h1>❌ Migration Error</h1><pre>" . $e->getMessage() . "</pre>";
    }
});
Route::get('/debug-db-config', function () {
    return [
        'ENV_DB_CONNECTION' => env('DB_CONNECTION'),
        'CONFIG_DEFAULT' => config('database.default'),
        'ENV_DB_HOST' => env('DB_HOST'),
    ];
});
Route::get('/debug-error', function () {
    try {
        // Try to create a dummy project to see where it crashes
        $test = \App\Models\Project::first();
        return "✅ Model works. Found " . ($test ? 1 : 0) . " projects.";
    } catch (\Exception $e) {
        return "<pre style='background:#f4f4f4;padding:20px;white-space:pre-wrap;'>❌ Error: " . $e->getMessage() . "\nFile: " . $e->getFile() . "\nLine: " . $e->getLine() . "\n\nTrace:\n" . $e->getTraceAsString() . "</pre>";
    }
});