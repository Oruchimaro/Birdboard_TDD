<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
	protected $tasksCount = 0;
	protected $user;

	/**
	 * Specify how many tasks this project should have
	 */
	public function withTasks($count)
	{
		$this->tasksCount = $count;

		return $this;
	}

	/**
	 * Specify a user as owner of this project
	 */
	public function ownedBy($user)
	{
		$this->user = $user;

		return $this;
	}


	/**
	 * Create an instance of the project and create tasks for it
	 *
	 */
	public function create()
	{
		$project = Project::factory()->create([
			'owner_id' => $this->user ?? User::factory()
		]);

		Task::factory($this->tasksCount)->create([ // when tasksCount = 0  this will not create anything
			'project_id' => $project->id
		]);

		return $project;
	}


}
