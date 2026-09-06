<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PublicProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_projects_are_rendered_from_the_cms_database(): void
    {
        Artisan::call('statecorps:import-legacy-content');
        $project = Project::where('status', 'published')->firstOrFail();

        $this->get('/projects')
            ->assertOk()
            ->assertSee('OUR PROJECTS')
            ->assertSee($project->title);

        $this->get('/projects/'.$project->slug)
            ->assertOk()
            ->assertSee($project->title);
    }
}
