<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

Route::get('/db-upload-form', function () {
    return '<form method="POST" enctype="multipart/form-data" action="/db-import"><input type="file" name="db_file" required><button>Upload DB</button></form>';
});

Route::post('/db-import', function (\Illuminate\Http\Request $request) {
    if ($request->hasFile('db_file')) {
        $file = $request->file('db_file');
        $destination = database_path('database.sqlite');
        
        // Backup old DB just in case
        if (File::exists($destination)) {
            File::copy($destination, database_path('database_backup.sqlite'));
        }
        
        // Move new DB
        $file->move(database_path(), 'database.sqlite');
        
        return '✅ Database imported successfully! Refresh your site.';
    }
    return '❌ No file uploaded.';
});
Route::get('/test-upload-page', function () {
    // Fetch all test uploads from database
    $uploads = DB::table('projects')
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
        // 1. Handle file upload
        $file = $request->file('cover_image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/projects/covers');
        
        // Ensure directory exists
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        
        // Move file
        if ($file->move($destinationPath, $filename)) {
            $imagePath = 'projects/covers/' . $filename;
            
            // 2. Insert into database
            $id = DB::table('projects')->insertGetId([
                'title' => $request->title,
                'slug' => \Illuminate\Support\Str::slug($request->title),
                'cover_image' => $imagePath,
                'type' => 'web',
                'category' => 'Test',
                'status' => 'completed',
                'short_description' => 'Test upload',
                'full_description' => 'Test upload description',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return back()->with('success', "✅ Upload successful! Image saved to: storage/projects/covers/{$filename}");
        } else {
            return back()->with('error', '❌ Failed to move uploaded file');
        }
    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
})->name('test.upload');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/create-admin', function () {
    $user = User::updateOrCreate(
        ['email' => 'abdullahtarhini55@gmail.com'],
        [
            'name' => 'Abdullah Tarhini',
            'password' => Hash::make('communication41730076'), // CHANGE THIS
        ]
    );
    return 'Admin user created/updated successfully!';
});

Route::get('/project/{slug}', [HomeController::class, 'show'])->name('project.show');