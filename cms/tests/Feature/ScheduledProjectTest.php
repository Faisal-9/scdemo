<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_future_published_project_is_hidden_until_its_publication_time(): void
    {
        $project = Project::create([
            'title' => 'Future project',
            'slug' => 'future-project',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $this->get('/projects')->assertOk()->assertDontSee($project->title);
        $this->get('/projects/'.$project->slug)->assertNotFound();
    }
}