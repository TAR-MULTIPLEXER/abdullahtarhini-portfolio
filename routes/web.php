<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::post('/laravel-upload-test', function (Request $request) {
    // Return raw JSON - no view, no Blade, no chance for 500 errors
    $response = ['status' => 'received', 'files' => []];
    
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        try {
            $path = $file->store('test-uploads', 'public');
            $response['status'] = 'success';
            $response['path'] = $path;
            $response['original_name'] = $file->getClientOriginalName();
        } catch (\Exception $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['status'] = 'no_file';
        $response['post_data'] = $request->all();
        $response['files'] = $request->files->all();
    }
    
    return response()->json($response);
});

// Simple GET route to show a plain HTML form (no Blade)
Route::get('/laravel-upload-test', function () {
    $csrf = csrf_token();
    return <<<HTML
    <!DOCTYPE html>
    <html>
    <head><title>Upload Test</title></head>
    <body>
        <h2>Simple Laravel Upload Test</h2>
        <form method="POST" enctype="multipart/form-data" action="/laravel-upload-test">
            <input type="hidden" name="_token" value="$csrf">
            <input type="file" name="photo" required>
            <button type="submit">Upload</button>
        </form>
        <div id="result" style="margin-top:20px; padding:10px; border:1px solid #ccc;"></div>
        <script>
        document.querySelector('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const res = await fetch(form.action, { method: 'POST', body: formData });
            const data = await res.json();
            document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        });
        </script>
    </body>
    </html>
    HTML;
});