<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $this->post($project->path() . '/tasks', [ 'body' => 'Test Case' ]);

        $this->get($project->path())->assertSee('Test Case');
    }

    public function test_only_the_owner_of_the_project_can_add_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $response = $this->post($project->path(). '/tasks', ['body' => 'Test Task']); //hit yhe endpoint

        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }


    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path(). '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
