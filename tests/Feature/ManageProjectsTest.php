<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }


    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(Response::HTTP_OK);

        $attributes = [
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(4)
        ];

        $response = $this->post('/projects', $attributes);

		$project = Project::where($attributes)->first();

		$response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);

        $this->get('/projects')->assertSee($attributes['description']);
    }


    public function test_a_user_can_view_their_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = Project::factory()->create([ 'owner_id' => auth()->id() ]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }


    public function test_an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }


    public function test_a_project_needs_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->make(['title' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }


    public function test_a_project_needs_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->make(['description' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** Model Tests */
    public function test_project_has_a_path()
    {
        $project = Project::factory()->make();

        $this->assertEquals('/projects/' . $project->id , $project->path());
    }

    public function test_project_belongs_to_an_owner()
    {
        $project = Project::factory()->make();

        $this->assertInstanceOf('App\Models\User', $project->owner);
    }

    public function test_project_can_add_tasks()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
