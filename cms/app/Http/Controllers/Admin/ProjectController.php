<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentRevision;
use App\Models\Project;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $projects = Project::query()
            ->with('images')
            ->when($request->string('search')->toString(), fn($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->latest('updated_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project(), 'sectors' => Sector::orderBy('title')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $project = new Project();
        $project->created_by = $request->user()->id;
        $this->persist($project, $request);

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project saved.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project, 'sectors' => Sector::orderBy('title')->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->persist($project, $request);

        return back()->with('success', 'Project updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project): RedirectResponse
    {
        abort_unless($request->user()->hasAnyRole('super_admin', 'admin'), 403);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    private function persist(Project $project, Request $request): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sector_id' => ['nullable', 'exists:sectors,id'],
            'client' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'project_status' => ['nullable', 'string', 'max:100'],
            'completion_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string'],
            'scope_text' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:10240'],
            'is_featured' => ['nullable', 'boolean'],
            'is_home_featured' => ['nullable', 'boolean'],
            'workflow_action' => ['required', 'in:draft,review,publish'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
            'review_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $before = $project->exists ? $project->toArray() : null;
        $data['slug'] = $project->slug ?: Str::slug($data['title']) . '-' . Str::lower(Str::random(6));
        $data['scope'] = collect(preg_split('/\r\n|\r|\n/', $data['scope_text'] ?? ''))->filter()->values()->all();
        unset($data['scope_text']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_home_featured'] = $request->boolean('is_home_featured');
        $data['status'] = $this->statusFor($request);
        $data['review_note'] = $data['review_note'] ?? null;
        unset($data['workflow_action']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }
        if ($data['status'] === 'published') {
            $data['published_by'] = $request->user()->id;
            $data['published_at'] = $data['scheduled_at'] ?? now();
            $data['scheduled_at'] = null;
        } elseif ($data['status'] === 'review') {
            $data['reviewed_by'] = null;
            $data['reviewed_at'] = null;
            $data['published_by'] = null;
            $data['published_at'] = null;
        } else {
            $data['published_by'] = null;
            $data['published_at'] = null;
        }

        $project->fill($data)->save();
        ContentRevision::create([
            'revisionable_type' => $project::class,
            'revisionable_id' => $project->id,
            'user_id' => $request->user()->id,
            'action' => $data['status'],
            'before' => $before,
            'after' => $project->fresh()->toArray(),
        ]);
    }

    private function statusFor(Request $request): string
    {
        $action = $request->string('workflow_action')->toString();
        if ($action === 'publish') {
            abort_unless($request->user()->hasAnyRole('super_admin', 'admin'), 403);
            return 'published';
        }

        return $action;
    }
}
