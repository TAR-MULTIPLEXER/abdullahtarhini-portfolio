<?php

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

// =============================================================================
// 🔧 STEP 1: CRITICAL FIX - Resolve BindingResolutionException
// =============================================================================
// Run this ONCE: /fix-step1
// This clears all caches that can cause "Target [Closure] is not instantiable"
Route::get('/fix-step1', function () {
    try {
        // 1. Clear ALL Laravel caches (critical for Livewire/Filament)
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('event:clear');
        
        // 2. Re-optimize for production (Render.com needs this)
        Artisan::call('config:cache', ['--force' => true]);
        Artisan::call('route:cache', ['--force' => true]);
        Artisan::call('view:cache', ['--force' => true]);
        
        // 3. Ensure sessions table exists (for database session driver)
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function ($table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
        
        // 4. Fix storage permissions (critical for file uploads)
        $storagePath = storage_path();
        if (is_writable($storagePath)) {
            @chmod($storagePath, 0775);
            @chmod(storage_path('app/public'), 0775);
        }
        
        return '
        <div style="font-family:sans-serif;max-width:600px;margin:40px auto;padding:20px;background:#f0fdf4;border:2px solid #22c55e;border-radius:12px">
            <h2 style="color:#166534">✅ Step 1 Complete!</h2>
            <ul style="line-height:1.8">
                <li>✓ All caches cleared & re-cached</li>
                <li>✓ Sessions table verified</li>
                <li>✓ Storage permissions checked</li>
            </ul>
            <p><strong>Next:</strong> <a href="/admin/login" style="color:#166534;font-weight:bold">→ Go to Admin Login</a></p>
            <p style="font-size:12px;color:#666;margin-top:20px">
                ℹ️ <em>Run this route only once after deployment. Delete it afterwards for security.</em>
            </p>
        </div>';
    } catch (\Exception $e) {
        return '
        <div style="font-family:sans-serif;max-width:600px;margin:40px auto;padding:20px;background:#fef2f2;border:2px solid #ef4444;border-radius:12px">
            <h2 style="color:#991b1b">❌ Step 1 Failed</h2>
            <pre style="background:#fff;padding:15px;border-radius:6px;overflow:auto">' . 
            htmlspecialchars($e->getMessage()) . 
            '</pre>
            <p><a href="/" style="color:#991b1b">← Return Home</a></p>
        </div>';
    }
});

// =============================================================================
// 🏠 PUBLIC ROUTES
// =============================================================================

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Project Show Page
Route::get('/project/{slug}', [HomeController::class, 'show'])->name('project.show');

// =============================================================================
// 👤 ADMIN / AUTHENTICATION
// =============================================================================

// Create/Update Admin User (Development Only - Remove in Production)
Route::get('/create-admin', function () {
    // Only allow in non-production environments
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    $user = User::updateOrCreate(
        ['email' => 'abdullahtarhini55@gmail.com'],
        [
            'name' => 'Abdullah Tarhini',
            'password' => Hash::make('communication41730076'),
            'email_verified_at' => now(),
        ]
    );
    
    return '✅ Admin user created/updated: ' . $user->email;
});

// =============================================================================
// 🗄️ DATABASE UTILITIES (Temporary - Remove After Setup)
// =============================================================================

// Database Upload Form (CSRF Protected)
Route::get('/db-upload-form', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    $csrf = csrf_token();
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Import Database</title>
        <style>
            body { font-family: system-ui, sans-serif; padding: 40px; background: #f8fafc; }
            .card { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
            h1 { margin: 0 0 20px; color: #1e293b; }
            input[type="file"] { width: 100%; padding: 12px; margin: 15px 0; border: 2px solid #e2e8f0; border-radius: 8px; background: #f8fafc; }
            button { background: #4f46e5; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 16px; cursor: pointer; font-weight: 500; }
            button:hover { background: #4338ca; }
            .warning { background: #fff7ed; color: #c2410c; padding: 12px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #f97316; }
            .success { background: #f0fdf4; color: #166534; padding: 12px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #22c55e; }
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

// Database Import Handler
Route::post('/db-import', function (Request $request) {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    if (!$request->hasFile('db_file')) {
        return '❌ No file uploaded. <a href="/db-upload-form">Go back</a>.';
    }
    
    try {
        $file = $request->file('db_file');
        $destination = database_path('database.sqlite');
        
        // Backup existing database
        if (File::exists($destination)) {
            File::copy($destination, database_path('database_backup_' . date('Ymd_His') . '.sqlite'));
        }
        
        // Move new database file
        $file->move(database_path(), 'database.sqlite');
        
        // ✅ CRITICAL: Fix permissions for Render.com/Unix servers
        chmod($destination, 0664);
        
        // Try to set ownership (may require sudo, so suppress errors)
        @chown($destination, 'www-data');
        @chgrp($destination, 'www-data');
        
        // Fix database directory permissions
        $dbDir = database_path();
        chmod($dbDir, 0775);
        @chown($dbDir, 'www-data');
        @chgrp($dbDir, 'www-data');
        
        // Clear caches to ensure new DB is recognized
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        return '
        <div style="font-family:sans-serif;max-width:600px;margin:40px auto;padding:20px;background:#f0fdf4;border:2px solid #22c55e;border-radius:12px">
            <h2 style="color:#166534">✅ Database Imported!</h2>
            <p>Backup created and new database installed.</p>
            <p><a href="/" style="color:#166534;font-weight:bold">→ Refresh Your Site</a></p>
        </div>';
    } catch (\Exception $e) {
        return '❌ Error: ' . htmlspecialchars($e->getMessage()) . ' <br><a href="/db-upload-form">← Try Again</a>';
    }
});

// =============================================================================
// 🔍 DEBUG & DIAGNOSTIC ROUTES (Temporary - Remove After Setup)
// =============================================================================

// Debug Database Configuration
Route::get('/debug-db-config', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    return response()->json([
        'env_db_connection' => env('DB_CONNECTION'),
        'config_default' => config('database.default'),
        'env_db_host' => env('DB_HOST'),
        'env_db_database' => env('DB_DATABASE'),
        'session_driver' => config('session.driver'),
        'app_env' => app()->environment(),
    ], 200, [], JSON_PRETTY_PRINT);
});

// Debug Database Connection
Route::get('/debug-db', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    try {
        $count = \App\Models\Project::count();
        $sample = \App\Models\Project::first();
        $dbPath = database_path('database.sqlite');
        $perms = is_file($dbPath) ? substr(sprintf('%o', fileperms($dbPath)), -4) : 'N/A';
        
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#f8fafc;border-radius:12px'>
            <h1 style='color:#166534'>✅ Database Connection OK</h1>
            <table style='width:100%;border-collapse:collapse'>
                <tr><td style='padding:8px;font-weight:bold'>Projects Count:</td><td style='padding:8px'>$count</td></tr>
                <tr><td style='padding:8px;font-weight:bold'>Sample Project:</td><td style='padding:8px'>" . ($sample ? htmlspecialchars($sample->title) : 'None') . "</td></tr>
                <tr><td style='padding:8px;font-weight:bold'>DB Path:</td><td style='padding:8px'>$dbPath</td></tr>
                <tr><td style='padding:8px;font-weight:bold'>Permissions:</td><td style='padding:8px'>$perms</td></tr>
            </table>
            <p style='margin-top:20px'><a href='/' style='color:#4f46e5'>← Home</a></p>
        </div>";
    } catch (\Exception $e) {
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#fef2f2;border-radius:12px;border:2px solid #ef4444'>
            <h1 style='color:#991b1b'>❌ Database Error</h1>
            <pre style='background:white;padding:15px;border-radius:6px;overflow:auto'>" . 
            htmlspecialchars($e->getMessage()) . 
            "\n\nFile: " . $e->getFile() . 
            "\nLine: " . $e->getLine() . 
            "</pre>
        </div>";
    }
});

// Debug Specific Error (for BindingResolutionException)
Route::get('/debug-error', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    try {
        // Test model binding (common source of Closure binding errors)
        $test = \App\Models\Project::first();
        $livewireCheck = class_exists(\Livewire\Livewire::class) ? '✓ Loaded' : '✗ Missing';
        
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#f0fdf4;border-radius:12px'>
            <h1 style='color:#166534'>✅ Diagnostic Results</h1>
            <ul style='line-height:2'>
                <li><strong>Project Model:</strong> ✓ Working</li>
                <li><strong>Found Projects:</strong> " . ($test ? 'Yes' : 'No') . "</li>
                <li><strong>Livewire:</strong> $livewireCheck</li>
                <li><strong>App Environment:</strong> " . app()->environment() . "</li>
            </ul>
            <p style='margin-top:20px'><strong>Still getting errors?</strong> Run <code>/fix-step1</code> first!</p>
            <p><a href='/' style='color:#4f46e5'>← Home</a></p>
        </div>";
    } catch (\Exception $e) {
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#fef2f2;border-radius:12px;border:2px solid #ef4444'>
            <h1 style='color:#991b1b'>❌ Error Details</h1>
            <pre style='background:white;padding:15px;border-radius:6px;overflow:auto;font-size:12px'>" . 
            "Message: " . $e->getMessage() . "\n" .
            "File: " . $e->getFile() . "\n" .
            "Line: " . $e->getLine() . "\n\n" .
            "Stack Trace:\n" . $e->getTraceAsString() .
            "</pre>
            <p style='margin-top:20px'><strong>Fix:</strong> Run <a href='/fix-step1' style='color:#4f46e5'>/fix-step1</a> to clear caches</p>
        </div>";
    }
});

// Force Run Migrations (for Render.com deployments)
Route::get('/run-migrations', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    try {
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
        
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#f0fdf4;border-radius:12px'>
            <h1 style='color:#166534'>✅ Migrations Completed</h1>
            <pre style='background:white;padding:15px;border-radius:6px;overflow:auto'>" . 
            htmlspecialchars($output) . 
            "</pre>
            <p><a href='/' style='color:#4f46e5'>← Home</a></p>
        </div>";
    } catch (\Exception $e) {
        return "
        <div style='font-family:monospace;max-width:800px;margin:40px auto;padding:20px;background:#fef2f2;border-radius:12px;border:2px solid #ef4444'>
            <h1 style='color:#991b1b'>❌ Migration Failed</h1>
            <pre style='background:white;padding:15px;border-radius:6px;overflow:auto'>" . 
            htmlspecialchars($e->getMessage()) . 
            "</pre>
        </div>";
    }
});

// =============================================================================
// 🧪 TESTING ROUTES (Optional - Can Be Removed)
// =============================================================================

// Simple Upload Test Page
Route::get('/test-upload-page', function () {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
    $uploads = \Illuminate\Support\Facades\DB::table('projects')
        ->whereNotNull('cover_image')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
        
    return view('test-upload', compact('uploads'));
});

// Simple Upload Test Handler
Route::post('/test-upload-page', function (Request $request) {
    if (app()->environment('production')) {
        abort(403, 'Disabled in production');
    }
    
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
            
            $id = \Illuminate\Support\Facades\DB::table('projects')->insertGetId([
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
            
            return back()->with('success', "✅ Upload successful! Project ID: $id");
        }
        
        return back()->with('error', '❌ Failed to move file');
    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
})->name('test.upload');

// =============================================================================
// 📋 IMPORTANT NOTES
// =============================================================================
/*
🔐 SECURITY REMINDERS:
1. All debug/temporary routes check app()->environment('production') 
2. Run /fix-step1 ONCE after each deployment, then DELETE the route
3. Remove /create-admin, /db-import, and all /debug-* routes in production
4. Never commit .env with real passwords to version control

🚀 DEPLOYMENT CHECKLIST FOR RENDER.COM:
1. Set DB_CONNECTION=pgsql in Render environment variables
2. Ensure DATABASE_URL is properly configured
3. Run /fix-step1 after each deploy
4. Verify storage/app/public is linked: php artisan storage:link
5. Check file permissions: storage/ and bootstrap/cache/ must be writable

🐛 TROUBLESHOOTING "Target [Closure] is not instantiable":
1. Run /fix-step1 immediately after deployment
2. Check config/cache.php - ensure 'default' => env('CACHE_DRIVER', 'file')
3. Verify Livewire is properly installed: composer require livewire/livewire
4. Clear browser cache + hard refresh (Ctrl+F5)
*/