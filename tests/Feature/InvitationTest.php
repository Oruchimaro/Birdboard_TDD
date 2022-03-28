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

	public function test_non_owners_may_not_invite_users()
	{
		$project = ProjectFactory::create();

		$user = User::factory()->create();

		$this->actingAs($user)
			->post($project->path().'/invitations')
			->assertStatus(403);
	}


	public function test_a_project_owner_can_invite_a_user()
	{
		$project = ProjectFactory::create();

		$userToInvite = User::factory()->create();

		$this->actingAs($project->owner)
			->post($project->path().'/invitations', [
				'email' => $userToInvite->email
			])
			->assertRedirect($project->path());

		$this->assertTrue($project->members->contains($userToInvite));
	}


	public function test_invited_email_address_is_valid_birdboard_account()
	{
		$project = ProjectFactory::create();

		$this->actingAs($project->owner)
			->post($project->path().'/invitations', [
				'email' => 'notauser@example.com'
			])
			->assertSessionHasErrors([
				'email' => 'The user you are inviting must have a BirdBoard account.'
			]);
	}


	public function test_invited_users_may_update_project_details()
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

		$this->assertDatabaseHas('tasks', $task);
	}
}
