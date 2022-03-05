<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker()->sentence(),
            'description' => $this->faker()->paragraph(2)
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);

        $this->get('/projects')->assertSee($attributes['description']);
    }

    public function test_a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }


    public function test_user_can_only_see_existing_projects()
    {
        $project = Project::factory()->create();

        $this->assertDatabaseCount('projects', 1);

        $this->get($project->path(2))->assertStatus(404);
    }


    public function test_a_project_needs_a_title()
    {
        $attributes = Project::factory()->make(['title' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }



    public function test_a_project_needs_a_description()
    {
        $attributes = Project::factory()->make(['description' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    public function test_project_has_a_path()
    {
        $attributes = [
            'title' => $this->faker()->sentence(),
            'description' => $this->faker()->paragraph(2)
        ];

        $project = Project::create($attributes);

        $this->assertEquals('/projects/' . $project->id , $project->path());
    }
}
