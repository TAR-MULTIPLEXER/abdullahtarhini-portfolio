<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Test - Simple & Direct</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5; 
            padding: 20px; 
            line-height: 1.6;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 { 
            color: #333; 
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #4F46E5;
        }
        button {
            background: #4F46E5;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #4338CA;
        }
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
        }
        .alert-success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }
        .alert-error {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 20px;
        }
        .gallery-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .gallery-info {
            padding: 16px;
        }
        .gallery-info h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }
        .gallery-info p {
            font-size: 13px;
            color: #666;
            word-break: break-all;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #4F46E5;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Upload Form -->
        <div class="card">
            <h1>📤 Simple Upload Test</h1>
            <p class="subtitle">Upload an image → Save to database → Display below</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="title">Project Title *</label>
                    <input type="text" name="title" id="title" required 
                           placeholder="e.g., My Test Project"
                           value="{{ old('title') }}">
                </div>
                
                <div class="form-group">
                    <label for="cover_image">Cover Image *</label>
                    <input type="file" name="cover_image" id="cover_image" required 
                           accept="image/*">
                    <small style="color: #666; display: block; margin-top: 6px;">
                        Accepted: JPEG, PNG, JPG, GIF (Max 5MB)
                    </small>
                </div>
                
                <button type="submit">🚀 Upload & Save to Database</button>
            </form>
        </div>
        
        <!-- Uploaded Images Gallery -->
        <div class="card">
            <h2>🖼️ Uploaded Images (from Database)</h2>
            <p class="subtitle">These images are stored in the database and displayed from storage/</p>
            
            @if($uploads->count() > 0)
                <div class="gallery">
                    @foreach($uploads as $upload)
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $upload->cover_image) }}" 
                                 alt="{{ $upload->title }}"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23ddd%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23999%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            <div class="gallery-info">
                                <h3>{{ $upload->title }}</h3>
                                <p><strong>Path:</strong> {{ $upload->cover_image }}</p>
                                <p><strong>ID:</strong> {{ $upload->id }}</p>
                                <span class="badge">{{ $upload->type }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p>No uploads yet. Be the first!</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>