@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #0f172a;
        --accent: #06b6d4;
        --accent-hover: #0891b2;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --white: #ffffff;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        --radius: 0.5rem;
        --radius-lg: 1rem;
        --radius-xl: 1.5rem;
        --radius-full: 9999px;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--gray-50); color: var(--gray-800); line-height: 1.6; }
    
    h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', 'Inter', sans-serif; font-weight: 700; line-height: 1.2; color: var(--primary); }
    a { text-decoration: none; color: inherit; transition: 0.3s; }
    a:hover { color: var(--accent); }
    img { max-width: 100%; height: auto; display: block; }
    button { cursor: pointer; border: none; font: inherit; background: none; }
    input, textarea { font: inherit; }
    
    /* Utilities */
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
    .flex { display: flex; }
    .flex-wrap { flex-wrap: wrap; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }
    .gap-8 { gap: 2rem; }
    .gap-12 { gap: 3rem; }
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: 1fr; }
    .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
    
    /* Responsive Grid Utilities */
    @media (min-width: 768px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .md\:col-span-2 { grid-column: span 2 / span 2; }
    }
    @media (min-width: 1024px) {
        .lg\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
    }

    .text-center { text-align: center; }
    .text-sm { font-size: 0.875rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-2xl { font-size: 1.5rem; }
    .text-3xl { font-size: 1.875rem; }
    .text-4xl { font-size: 2.25rem; }
    .text-5xl { font-size: 3rem; }
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .uppercase { text-transform: uppercase; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mb-12 { margin-bottom: 3rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mt-8 { margin-top: 2rem; }
    .mt-12 { margin-top: 3rem; }
    .py-3 { padding: 0.75rem 0; }
    .py-6 { padding: 1.5rem 0; }
    .py-8 { padding: 2rem 0; }
    .py-12 { padding: 3rem 0; }
    .py-20 { padding: 5rem 0; }
    .px-3 { padding: 0 0.75rem; }
    .px-4 { padding: 0 1rem; }
    .px-6 { padding: 0 1.5rem; }
    .px-8 { padding: 0 2rem; }
    .rounded { border-radius: 0.25rem; }
    .rounded-lg { border-radius: var(--radius-lg); }
    .rounded-xl { border-radius: var(--radius-xl); }
    .rounded-full { border-radius: var(--radius-full); }
    .shadow { box-shadow: var(--shadow); }
    .shadow-lg { box-shadow: var(--shadow-lg); }
    .shadow-2xl { box-shadow: var(--shadow-2xl); }
    .overflow-hidden { overflow: hidden; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .top-4 { top: 1rem; }
    .left-4 { left: 1rem; }
    .right-4 { right: 1rem; }
    .z-10 { z-index: 10; }
    .w-full { width: 100%; }
    .h-48 { height: 12rem; }
    .h-56 { height: 14rem; }
    .h-64 { height: 16rem; }
    .object-cover { object-fit: cover; }
    .leading-relaxed { line-height: 1.625; }
    .transition { transition: all 0.3s ease; }
    .transform { transform: translateZ(0); }
    .cursor-pointer { cursor: pointer; }
    .space-y-4 > * + * { margin-top: 1rem; }
    .space-y-6 > * + * { margin-top: 1.5rem; }
    
    /* Colors */
    .bg-primary { background: var(--primary); }
    .bg-white { background: var(--white); }
    .bg-gray-50 { background: var(--gray-50); }
    .bg-gray-100 { background: var(--gray-100); }
    .bg-accent { background: var(--accent); }
    .bg-red-600 { background: #dc2626; }
    .bg-white\/10 { background: rgba(255,255,255,0.1); }
    .bg-accent\/10 { background: rgba(6, 182, 212, 0.1); }
    .text-primary { color: var(--primary); }
    .text-white { color: var(--white); }
    .text-accent { color: var(--accent); }
    .text-red-600 { color: #dc2626; }
    .text-slate-300 { color: #cbd5e1; }
    .text-slate-500 { color: #64748b; }
    .text-slate-600 { color: #475569; }
    .text-gray-600 { color: var(--gray-600); }
    .border { border: 1px solid; }
    .border-gray-100 { border-color: var(--gray-100); }
    .border-t { border-top: 1px solid; }
    
    /* Buttons */
    .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: var(--radius-full); transition: 0.3s; }
    .btn-accent { background: var(--accent); color: var(--white); }
    .btn-accent:hover { background: var(--accent-hover); }
    .btn-white { background: var(--white); color: var(--primary); }
    .btn-white:hover { background: var(--gray-100); }
    .btn-red { background: #dc2626; color: var(--white); }
    .btn-red:hover { background: #b91c1c; }
    
    /* Badges */
    .badge { display: inline-block; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; border-radius: var(--radius-full); }
    .badge-cyan { background: var(--accent); color: white; }
    .badge-orange { background: #f97316; color: white; }
    .badge-purple { background: #a855f7; color: white; }
    .badge-blue { background: #2563eb; color: white; }
    .badge-gray { background: #64748b; color: white; }
    
    /* Project Card */
    .project-card { background: var(--white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow); transition: 0.3s; }
    .project-card:hover { box-shadow: var(--shadow-2xl); transform: translateY(-4px); }
    
    /* Gallery */
    .gallery-item { background: var(--white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow); transition: 0.3s; }
    .gallery-item:hover { box-shadow: var(--shadow-2xl); }
    
    /* Modal */
    .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 100; display: none; align-items: center; justify-content: center; padding: 1rem; }
    .modal.active { display: flex; }
    .modal img { max-width: 100%; max-height: 90vh; border-radius: var(--radius-lg); }
    /* .modal-close { position: absolute; top: 0.5rem; right: 1rem; color: white; font-size: 2.5rem; cursor: pointer; transition: 0.3s; }
    .modal-close:hover { color: var(--accent); } */
    
    /* Footer */
    .footer { background: var(--gray-900); color: var(--gray-300); padding: 3rem 0; border-top: 1px solid var(--gray-800); }
    .footer-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .footer-grid { grid-template-columns: repeat(4, 1fr); } }
    .footer-brand h3 { color: var(--white); font-size: 1.25rem; margin-bottom: 1rem; }
    .footer-links h4 { color: var(--white); font-weight: 700; margin-bottom: 1rem; }
    .footer-links a { font-size: 0.875rem; transition: 0.3s; }
    .footer-links a:hover { color: var(--accent); }
    .footer-copyright { text-align: center; padding-top: 2rem; margin-top: 2rem; border-top: 1px solid var(--gray-800); font-size: 0.75rem; color: var(--gray-500); }
    
    /* Prose */
    .prose { font-size: 1rem; line-height: 1.75; color: var(--gray-600); }
    .prose p { margin-bottom: 1rem; }
    .prose ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .prose li { margin-bottom: 0.25rem; }
    .prose strong { color: var(--primary); font-weight: 600; }
    
    /* ===== PDF Document Cards (Responsive Fixed) ===== */
    .pdf-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--gray-200);
    }
    .pdf-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .pdf-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: #ef4444;
        flex-shrink: 0;
    }
    
    /* PDF Grid: 1 col on mobile, 2 cols on tablet+ */
    .pdf-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    @media (min-width: 768px) {
        .pdf-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .pdf-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        transition: box-shadow 0.2s;
    }
    .pdf-card:hover {
        box-shadow: var(--shadow-lg);
    }
    .pdf-card-icon {
        flex-shrink: 0;
        margin-right: 1rem;
        color: #ef4444;
    }
    .pdf-card-icon svg {
        width: 2.5rem;
        height: 2.5rem;
    }
    .pdf-card-content {
        flex: 1;
        min-width: 0; /* Prevents overflow */
    }
    .pdf-card-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .pdf-card-type {
        font-size: 0.75rem;
        color: var(--gray-500);
    }
    
    /* Action Buttons Container */
    .pdf-card-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
    
    .pdf-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 0.875rem;
        font-size: 0.8125rem;
        font-weight: 500;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .pdf-btn svg {
        width: 0.875rem;
        height: 0.875rem;
        margin-right: 0.375rem;
        flex-shrink: 0;
    }

    /* View Button - Blue */
    .pdf-btn-view {
        color: #2563eb;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
    }
    .pdf-btn-view:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        transform: translateY(-1px);
    }

    /* Download Button - Green */
    .pdf-btn-download {
        color: #059669;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
    }
    .pdf-btn-download:hover {
        background: #d1fae5;
        border-color: #6ee7b7;
        transform: translateY(-1px);
    }

    /* Mobile Adjustments for PDF Card */
    @media (max-width: 640px) {
        .pdf-card {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        .pdf-card-icon {
            margin-right: 0;
            margin-bottom: 0.75rem;
        }
        .pdf-card-content {
            width: 100%;
            margin-bottom: 0.75rem;
        }
        .pdf-card-actions {
            margin-left: 0;
            width: 100%;
            justify-content: flex-end; /* Align buttons to right */
        }
        .pdf-btn {
            flex: 1; /* Make buttons fill width on very small screens if needed */
            justify-content: center;
        }
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        body { background: #0f172a; color: #e2e8f0; }
        .bg-white { background: #1e293b; }
        .bg-gray-50 { background: #0f172a; }
        .text-primary { color: #f8fafc; }
        .text-gray-600 { color: #94a3b8; }
        .border-gray-200 { border-color: #334155; }
        .pdf-card { background: #1e293b; border-color: #334155; }
        .pdf-card-title { color: #f1f5f9; }
        .pdf-card-type { color: #94a3b8; }
        .pdf-section { border-top-color: #334155; }
        .pdf-btn-view {
            color: #93c5fd;
            background: #1e3a8a;
            border-color: #1e40af;
        }
        .pdf-btn-view:hover {
            background: #1e40af;
            border-color: #3b82f6;
        }
        .pdf-btn-download {
            color: #6ee7b7;
            background: #064e3b;
            border-color: #065f46;
        }
        .pdf-btn-download:hover {
            background: #065f46;
            border-color: #10b981;
        }
    }
</style>

@include('partials.navbar')

<!-- Back Button -->
<div class="container mx-auto px-6 py-8">
    <a href="{{ route('home') }}" class="text-accent hover:text-cyan-600 font-semibold">
        <i class="fas fa-arrow-left mr-2"></i> Back to Projects
    </a>
</div>

<!-- Hero Section -->
<section class="bg-primary text-white py-20">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-accent font-bold uppercase text-sm">{{ $project->category }}</span>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 mb-4" style="color:white;">{{ $project->title }}</h1>
                
                <div class="flex gap-3 mb-6">
                    <span class="px-3 py-1 bg-white/10 rounded-full text-sm">{{ ucfirst($project->type) }}</span>
                    <span class="px-3 py-1 bg-white/10 rounded-full text-sm">{{ ucfirst($project->status) }}</span>
                </div>
                
                <p class="text-slate-300 text-lg mb-6">{{ $project->short_description }}</p>
                
                <div class="flex gap-4 flex-wrap">
                    @if($project->github_link)
                    <a href="{{ $project->github_link }}" target="_blank" class="btn btn-white">
                        <i class="fab fa-github mr-2"></i> View Code
                    </a>
                    @endif
                    
                    @if($project->video_url)
                    <a href="{{ $project->video_url }}" target="_blank" class="btn btn-red">
                        <i class="fas fa-play mr-2"></i> Watch Demo
                    </a>
                    @endif
                    @if ($project->live_link)
                    <a href="{{ $project->live_link }}" target="_blank" class="btn btn-white">
                        <i class="fas fa-external-link" style="margin-right: 5px;"></i> View site
                    </a>
                    @endif
                    @if(!$project->live_link)
                    <a href="mailto:your.email@example.com?subject=Demo Request: {{ $project->title }}" class="btn btn-accent">
                        <i class="fas fa-envelope mr-2"></i> Request Demo
                    </a>
                    @endif
                </div>
            </div>
            <div class="relative">
                @if(!empty($project->cover_image))
                    <img src="{{ Storage::url($project->cover_image) }}" alt="{{ $project->title }}" class="rounded-2xl shadow-2xl w-full">
                @elseif(!empty($project->image_details) && !empty($project->image_details[0]['image']))
                    <img src="{{ Storage::url($project->image_details[0]['image']) }}" alt="{{ $project->title }}" class="rounded-2xl shadow-2xl w-full">
                @elseif(!empty($project->images) && count($project->images) > 0)
                    <img src="{{ Storage::url($project->images[0]) }}" alt="{{ $project->title }}" class="rounded-2xl shadow-2xl w-full">
                @else
                    <div class="w-full h-64 bg-gray-700 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-gray-500"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Project Details -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="md:col-span-2">
                <h2 class="text-3xl font-bold text-primary mb-6">Project Overview</h2>
                
                {{-- Render full description safely --}}
                <div class="prose max-w-none">
                    {!! $project->full_description !!}
                </div>
                
                {{-- ===== PDF DOCUMENTS SECTION ===== --}}
                @if($project->pdfs && is_array($project->pdfs) && count($project->pdfs) > 0)
                    <div class="pdf-section">
                        <h3 class="pdf-title">
                            <svg class="pdf-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            Project Documents
                        </h3>
                        
                        <div class="pdf-grid">
                            @foreach($project->pdfs as $pdf)
                                <div class="pdf-card">
                                    <div class="pdf-card-icon">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="pdf-card-content">
                                        <p class="pdf-card-title">{{ $pdf['title'] ?? 'Document' }}</p>
                                        <p class="pdf-card-type">PDF File</p>
                                    </div>
                                  <div class="pdf-card-actions">
    {{-- View Button (opens in new tab) --}}
    <a href="{{ Storage::url($pdf['path']) }}" 
       target="_blank"
       class="pdf-btn pdf-btn-view"
       title="View PDF in browser">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        View
    </a>
    
    {{-- Download Button (forces download) --}}
    <a href="{{ Storage::url($pdf['path']) }}" 
       download="{{ $pdf['title'] ?? 'document' }}.pdf"
       class="pdf-btn pdf-btn-download"
       title="Download PDF file">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Download
    </a>
</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Image Gallery -->
                @if(!empty($project->image_details) && is_array($project->image_details) && count($project->image_details) > 1)
                    @if($project->gallery_description)
                    <h2 class="text-3xl font-bold text-primary mb-2 mt-12">Project Gallery</h2>
                    <p class="text-gray-600 mb-6">{{ $project->gallery_description }}</p>
                    @else
                    <h2 class="text-3xl font-bold text-primary mb-6 mt-12">Project Gallery</h2>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($project->image_details as $detail)
                            @if(!empty($detail['image']))
                            <div class="gallery-item">
                                <img src="{{ Storage::url($detail['image']) }}" alt="{{ $project->title }}" class="w-full h-56 object-cover cursor-pointer" onclick="showImageModal('{{ Storage::url($detail['image']) }}')">
                                @if(!empty($detail['description']))
                                <div class="p-4 border-t border-gray-100">
                                    <p align="center" class="text-gray-600 text-sm">{{ $detail['description'] }}</p>
                                </div>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                @elseif(!empty($project->images) && is_array($project->images) && count($project->images) > 1)
                    <h2 class="text-3xl font-bold text-primary mb-6 mt-12">Project Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->images as $image)
                            @if(!empty($image))
                            <img src="{{ Storage::url($image) }}" alt="{{ $project->title }}" class="rounded-lg shadow-md hover:shadow-lg transition cursor-pointer" onclick="showImageModal('{{ Storage::url($image) }}')">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">Project Info</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-slate-500">Type</div>
                            <div class="font-semibold">{{ ucfirst($project->type) }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-500">Status</div>
                            <div class="font-semibold">{{ ucfirst($project->status) }}</div>
                        </div>
                        @if($project->tools_used)
                        <div>
                            <div class="text-sm text-slate-500">Technologies</div>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach(explode(',', $project->tools_used) as $tool)
                                <span class="px-2 py-1 bg-white rounded text-xs text-slate-600">{{ trim($tool) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-accent/10 rounded-2xl p-4">
                    <h3 class="text-xl font-bold text-primary mb-4">Interested?</h3>
                    <p class="text-slate-600 text-sm mb-4">This project is available for demonstration. Contact me to learn more.</p>
                    <a href="https://wa.me/96170389556" target="_blank" class="btn btn-accent w-full">Contact Me</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedProjects->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center">Related Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedProjects as $related)
                @include('partials.project-card', ['project' => $related])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Image Modal -->
<div id="imageModal" class="modal" onclick="if(event.target === this) closeModal()">
    <span class="modal-close" onclick="closeModal()" style="cursor: pointer; font-size: 1.5rem;">&times;</span>
    <img id="modalImg" src="" alt="">
</div>

@include('partials.footer')

<script>
function showImageModal(src) {
    document.getElementById('modalImg').src = src;
    document.getElementById('imageModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('imageModal').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>

@endsection