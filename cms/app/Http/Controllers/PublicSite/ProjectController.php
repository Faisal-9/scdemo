<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->with('sector')
            ->publiclyVisible()
            ->orderByDesc('completion_year')
            ->get();
        $hero = SiteSetting::where('key', 'projects.hero')->first()?->value ?? [
            'title' => 'Projects',
            'subtitle' => 'Delivering infrastructure that strengthens communities.',
            'background' => 'assets/images/projects/project-hero.jpg',
            'stats' => [],
        ];

        return view('public.projects.index', compact('projects', 'hero'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->status === 'published' && (! $project->published_at || $project->published_at->isPast()), 404);

        return view('public.projects.show', ['project' => $project->load(['sector', 'images'])]);
    }

    public function legacy(Request $request): RedirectResponse
    {
        $project = Project::where('slug', $request->string('id')->toString())->firstOrFail();

        return redirect()->route('projects.show', $project, 301);
    }
}
