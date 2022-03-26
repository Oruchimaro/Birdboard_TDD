<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_project_can_invite_a_user()
	{
		$project = ProjectFactory::create();

		$project->invite($newUser = User::factory()->create());

		$this->signIn($newUser);

		$this->post(
			action(
				[ProjectTasksController::class, 'store'],
				['project' => $project]
			),
			$task = ['body' => 'Foo Task']
		);
		// $this->post( action([ProjectTasksController::class, 'store'], ['project' => $project->id]) );

		$this->assertDatabaseHas('tasks', $task);
	}
}
