<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->
			post($project->path() . '/tasks', [ 'body' => 'Test Case' ]);

        $this->get($project->path())->assertSee('Test Case');
    }


    public function test_a_task_can_be_updated()
    {
		$project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
			->patch($project->tasks->first()->path(), [
				'body' => 'Changed',
			]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed',
        ]);
    }

	public function test_a_task_can_be_completed()
    {
		$project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
			->patch($project->tasks->first()->path(), [
				'body' => 'Changed',
				'completed' => true
			]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed',
            'completed' => true
        ]);
    }

	public function test_a_task_can_be_marked_as_incomplete()
    {
		$this->withoutExceptionHandling();

		$project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
			->patch($project->tasks->first()->path(), [
				'body' => 'Changed',
				'completed' => true
			]);

		$this->actingAs($project->owner)
			->patch($project->tasks->first()->path(), [
				'body' => 'Changed',
				'completed' => false
			]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed',
            'completed' => false
        ]);
    }

    public function test_only_the_owner_of_the_project_can_add_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $response = $this->post($project->path(). '/tasks', ['body' => 'Test Task']); //hit yhe endpoint

        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }

	public function test_only_the_owner_of_the_project_may_update_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $response = $this->patch($project->tasks[0]->path() , ['body' => 'Changed']);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);
    }


    public function test_a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
			->post($project->path(). '/tasks', $attributes)
			->assertSessionHasErrors('body');
    }


	/** Model Test */
	public function test_a_task_belongs_to_a_project()
	{
		$task = Task::factory()->create();

		$this->assertInstanceOf(Project::class, $task->project);

	}

	public function test_it_has_a_path()
	{
		$task = Task::factory()->create();

		$this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
	}

	public function test_it_can_be_completed()
	{
		$task = Task::factory()->create();

		$this->assertFalse($task->completed);

		$task->complete();

		$this->assertTrue($task->fresh()->completed);
	}

	public function test_it_can_be_marked_as_incomplete()
	{
		$task = Task::factory()->create(['completed' =>true]);

		$this->assertTrue($task->completed);

		$task->incomplete();

		$this->assertFalse($task->fresh()->completed);
	}
}
