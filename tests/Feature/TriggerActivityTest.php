<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
	use RefreshDatabase;

	public function test_creating_a_project()
	{
		$project = ProjectFactory::create();

		$this->assertCount(1, $project->activity);

		tap($project->activity->last(), function ($activity){

			$this->assertEquals('created_project', $activity->description);

			$this->assertNull($activity->changes);
		});
	}

	public function test_updating_a_project()
	{
		$project = ProjectFactory::create();

		$original_title = $project->title;

		$project->update(['title' => 'Changed']);

		$this->assertCount(2, $project->activity);

		tap($project->activity->last(), function ($activity) use ($original_title){
			$this->assertEquals('updated_project', $activity->description);

			$expected = [
				'before' =>['title' =>$original_title],
				'after' => ['title' => 'Changed']
			];

			$this->assertEquals($expected, $activity->changes);
		});
	}

	public function test_creating_a_task()
	{
		$project = ProjectFactory::create();

		$project->addTask('Some Task');

		$this->assertCount(2, $project->activity);

		tap( $project->activity->last(), function($activity){
			$this->assertEquals('created_task', $activity->description);

			$this->assertInstanceOf(Task::class, $activity->subject);

			$this->assertEquals('Some Task', $activity->subject->body);
		} );
	}

	public function test_completing_a_task()
	{
		$project = ProjectFactory::withTasks(1)->create();

		$this->actingAs($project->owner)
			->patch($project->tasks[0]->path(), [
				'body' => 'foobar',
				'completed' => true
			]);

		$this->assertCount(3, $project->activity);

		tap( $project->activity[2], function($activity){
			$this->assertEquals('completed_task', $activity->description);

			$this->assertInstanceOf(Task::class, $activity->subject);
		} );
	}

	public function test_incompleting_a_task()
	{
		$project = ProjectFactory::withTasks(1)->create();

		$this->actingAs($project->owner)
			->patch($project->tasks[0]->path(), [
				'body' => 'foobar',
				'completed' => true
			]);

		$this->assertCount(3, $project->activity); // 1 for project, 1 for creating a task, 1 for completing a task

		$this->patch($project->tasks[0]->path(), [
			'body' => 'foobar',
			'completed' => false
		]);

		$this->assertCount(4, $project->fresh()->activity); // 1 for project, 1 for creating a task, 1 for completing a task, 1 for incompleting a task

		$this->assertEquals('incompleted_task', $project->fresh()->activity[3]->description);
	}

	public function test_deleting_a_task()
	{
		$project = ProjectFactory::withTasks(1)->create();

		$project->tasks[0]->delete();

		$this->assertCount(3, $project->activity); // 1 for creating project, 1 for creating a task, 1 for deleting a task
		$this->assertEquals('deleted_task', $project->activity[2]->description);
	}
}
