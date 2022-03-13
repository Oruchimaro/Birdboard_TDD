<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
	use RefreshDatabase;

	public function test_creating_a_project_records_activity()
	{
		$project = ProjectFactory::create();

		$this->assertCount(1, $project->activity);

		$this->assertEquals('created', $project->activity[0]->description);
	}


	public function test_updating_a_project_records_activity()
	{
		$project = ProjectFactory::create();

		$project->update(['title' => 'Changed']);

		$this->assertCount(2, $project->activity);

		$this->assertEquals('updated', $project->activity[1]->description);
	}


	public function test_creating_a_new_task_records_project_activity()
	{
		$project = ProjectFactory::create();

		$project->addTask('Some Task');

		$this->assertCount(2, $project->activity);
		$this->assertEquals('created_task', $project->activity[1]->description);
	}


	public function test_completing_a_task_records_project_activity()
	{
		$project = ProjectFactory::withTasks(1)->create();

		$this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
			'body' => 'foobar',
			'completed' => true
		]);

		$this->assertCount(3, $project->activity);
		$this->assertEquals('completed_task', $project->activity[2]->description);
	}
}
