<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Upload Test</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; }
        .box { border: 1px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 8px; }
        .success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .warning { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        pre { background: #f4f4f4; padding: 10px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🧪 Laravel Native Upload Test</h1>
    <p>This test uses standard Laravel Form Submission (NOT Livewire).</p>

    @if(isset($message))
        <div class="box {{ $type }}">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="box">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <label for="photo">Choose an image:</label><br><br>
            <input type="file" name="photo" id="photo" required>
            <br><br>
            <button type="submit">Upload via Laravel</button>
        </form>
    </div>

    @if(isset($debug))
        <div class="box">
            <h3>Debug Info:</h3>
            <pre>{{ print_r($debug, true) }}</pre>
        </div>
    @endif
</body>
</html>