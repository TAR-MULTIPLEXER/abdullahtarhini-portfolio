<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();
        
        $allProjects = Project::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        $projectcount = Project::count();
        return view('welcome', compact('featuredProjects', 'allProjects', 'projectcount'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        
        $relatedProjects = Project::where('type', $project->type)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();
        
        return view('project-detail', compact('project', 'relatedProjects'));
    }
    public function manager()
    {
        return view('project-detail');
    }
}