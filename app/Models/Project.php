<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

   protected $fillable = [
    'title',
    'slug',
    'type',
    'category',
    'status',
    'short_description',
    'full_description',
    'pdfs',
    'gallery_description',
    'cover_image', 
    'image_details',
    'images',
    'video_url',
    'diagram_url',
    'github_link',
    'live_link',
    'documentation_link',
    'specifications',
    'tools_used',
    'is_featured',
    'sort_order',
    'show_gallery_description',
];

    protected $casts = [
        'images' => 'array',
        'image_details' => 'array',
        'specifications' => 'array',
        'is_featured' => 'boolean',
          'pdfs' => 'array',
        'show_gallery_description' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function getTypeBadgeColor(): string
    {
        return match($this->type) {
            'hardware' => 'bg-orange-500',
            'desktop' => 'bg-purple-500',
            'telecom' => 'bg-blue-600',
            default => 'bg-cyan-500',
        };
    }

    public function hasLiveLink(): bool
    {
        return !empty($this->live_link);
    }

    public function isLocalProject(): bool
    {
        return in_array($this->type, ['desktop', 'hardware']) && empty($this->live_link);
    }
}