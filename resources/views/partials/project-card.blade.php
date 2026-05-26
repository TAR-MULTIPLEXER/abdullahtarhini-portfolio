<div class="project-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-200" 
     data-type="{{ $project->type }}" 
     data-status="{{ $project->status }}">
    
    <!-- Clickable Cover Image -->
  <a href="{{ route('project.show', $project->slug) }}" class="block">
    <div class="relative h-48 overflow-hidden bg-gray-100">
        
        {{-- 1. Check for Base64 Cover Image (New Method) --}}
        @if(!empty($project->cover_image_data))
            <img src="data:image/jpeg;base64,{{ $project->cover_image_data }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        
        {{-- 2. Fallback: Check for Old Path-Based Cover Image --}}
        @elseif(!empty($project->cover_image))
            <img src="{{ asset('storage/' . $project->cover_image) }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        
        {{-- 3. Fallback: Check First Gallery Image (Base64) --}}
        @elseif(!empty($project->image_details))
            @php
                // Decode JSON if it's a string, otherwise use array
                $details = is_string($project->image_details) ? json_decode($project->image_details, true) : $project->image_details;
                $firstImage = $details[0]['image_data'] ?? null;
            @endphp
            
            @if($firstImage)
                <img src="data:image/jpeg;base64,{{ $firstImage }}" 
                     alt="{{ $project->title }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-project-diagram text-6xl text-white/50"></i>
                </div>
            @endif

        {{-- 4. Final Fallback: Placeholder --}}
        @else
            <div class="w-full h-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
                <i class="fas fa-project-diagram text-6xl text-white/50"></i>
            </div>
        @endif
        
        <span style="background-color: goldenrod; border-top-left-radius: 10px; border-bottom-left-radius: 10px; padding: 4px 8px; margin: 0;" class="absolute top-4 left-1 px-3 py-1 text-xs font-bold rounded-full text-white {{ $project->getTypeBadgeColor() }}">
            {{ ucfirst($project->type) }}
        </span> 
     
    </div>
</a>
    
    <div style="padding: 4px 8px;">
               @if($project->status == 'academic')
            <span style="color: blue; font-size: 11px; display: flex; float: right; right: 15px; font-weight:900;">
                <i class="fas fa-graduation-cap mr-1" style="margin-right: 3px; margin-top:2px;"></i> University
            </span>
            @elseif($project->status == 'completed')
            <span style="color: green; font-size: 11px; display: flex; float: right; right: 15px; font-weight:900;">
                <i class="fas fa-check-circle mr-1" style="margin-right: 3px; margin-top:2px;"></i> Completed
            </span>
            @elseif($project->status == 'ongoing')
            <span style="color: orange; font-size: 11px; display: flex; float: right; right: 15px; font-weight:900;">
                <i class="fas fa-sync mr-1"></i> Ongoing
            </span>

            @endif
        <span class="text-xs font-bold text-accent uppercase">{{ $project->category }}</span>
        <h3 class="text-xl font-bold mt-2 mb-2 text-primary">{{ $project->title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($project->short_description), 100) }}</p>
        
        @if($project->tools_used)
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach(explode(',', $project->tools_used) as $tool)
                @if(!empty(trim($tool)))
                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ trim($tool) }}</span>
                @endif
            @endforeach
        </div>
        @endif
        
        <div class="flex flex-wrap gap-2">
            @if($project->live_link)
                <a href="{{ $project->live_link }}" target="_blank" 
                   class="flex-1 bg-accent hover:bg-cyan-600 text-white text-center text-sm font-semibold py-2 px-4 rounded transition">
                    <i class="fas fa-external-link-alt mr-1"></i> Live Demo
                </a>
            @else
                <a href="{{ route('project.show', $project->slug) }}" 
                   class="flex-1 bg-gray-600 hover:bg-gray-700 text-black text-sm font-semibold py-2 px-4 rounded transition">
                    <i class="fas fa-info-circle mr-1"></i> View Details
                </a>
            @endif
            
            @if($project->github_link)
                <a href="{{ $project->github_link }}" target="_blank" 
                   class="px-4 py-2 border border-gray-300 hover:border-gray-600 rounded transition" title="GitHub">
                    <i class="fab fa-github"></i>
                </a>
            @endif
            
            @if($project->video_url)
                <a href="{{ $project->video_url }}" target="_blank" 
                   class="px-4 py-2 border border-gray-300 hover:border-red-500 rounded transition" title="Video Demo">
                    <i class="fas fa-play"></i>
                </a>
            @endif
        </div>
        
        @if(!$project->live_link)
        <p class="text-xs text-gray-500 mt-3 italic">
            <i class="fas fa-info-circle"></i> Local/Offline Project - Demo available upon request
        </p>
        @endif
    </div>
</div>