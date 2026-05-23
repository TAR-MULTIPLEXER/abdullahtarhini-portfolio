<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// ===== DATABASE IMPORT ROUTES (With CSRF Token) =====

Route::get('/db-upload-form', function () {
    $csrf = csrf_token();
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="warning">
                ⚠️ Warning: This will overwrite your production database!
            </div>
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
        
        return '✅ Database imported successfully! <a href="/">Refresh your site</a>.';
    }
    return '❌ No file uploaded. <a href="/db-upload-form">Go back</a>.';
});

// ===== SIMPLE UPLOAD TEST PAGE (Raw DB queries) =====

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
            
            // 2. Insert into database using Query Builder
            $id = DB::table('projects')->insertGetId([
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
            
            return back()->with('success', "✅ Upload successful! Image saved to: storage/projects/covers/{$filename}");
        } else {
            return back()->with('error', '❌ Failed to move uploaded file');
        }
    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
})->name('test.upload');

// ===== MODEL & DATABASE TEST (Uses Project Model) =====

Route::get('/test-model-upload', function () {
    // Fetch projects using the Model
    $projects = \App\Models\Project::orderBy('created_at', 'desc')->limit(10)->get();
    return view('test-model-upload', compact('projects'));
});

Route::post('/test-model-upload', function (Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
        'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);
    
    try {
        // 1. Handle File Upload
        $file = $request->file('cover_image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/projects/covers');
        
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        
        if (!$file->move($destinationPath, $filename)) {
            throw new \Exception("Failed to move uploaded file.");
        }
        
        $imagePath = 'projects/covers/' . $filename;

        // 2. Create Project Using the MODEL (Eloquent)
        $project = new \App\Models\Project();
        $project->title = $request->title;
        $project->slug = Str::slug($request->title);
        $project->type = 'web';
        $project->category = 'Test Model';
        $project->status = 'completed';
        $project->short_description = 'Created via Model Test';
        $project->full_description = 'This proves Eloquent works.';
        $project->cover_image = $imagePath;
        $project->save();

        return back()->with('success', "✅ SUCCESS! Project ID {$project->id} created via Model. Image saved.");

    } catch (\Exception $e) {
        return back()->with('error', '❌ ERROR: ' . $e->getMessage());
    }
})->name('test.model.upload');

// ===== YOUR ORIGINAL ROUTES =====

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