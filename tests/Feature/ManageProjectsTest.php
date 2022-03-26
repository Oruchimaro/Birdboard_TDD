<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Response;
use Facades\Tests\Setup\ProjectFactory;
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
        $this->get( $project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->delete($project->path())->assertRedirect('login');
    }


    public function test_a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(Response::HTTP_OK);

        $attributes = [
            'title' => $this->faker()->sentence(4),
            'description' => $this->faker()->sentence(4),
			'notes' => 'general notes here.'
        ];

        $response = $this->post('/projects', $attributes);

		$project = Project::where($attributes)->first();

		$response->assertRedirect($project->path());

        $this->get($project->path())
			->assertSee($attributes['title'])
			->assertSee($attributes['description'])
			->assertSee($attributes['notes']);
    }


	public function test_a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

		$this->actingAs($project->owner)
			->patch($project->path(), $attributes = [
				'title' => 'Changed',
				'description' => 'Changed',
				'notes' => 'Changed'
			])
			->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

	public function test_a_user_can_delete_a_project()
	{
		$project = ProjectFactory::create();

		$this->actingAs($project->owner)
			->delete($project->path())
			->assertRedirect('/projects');

		$this->assertDatabaseMissing('projects', $project->only('id'));

		// Or can be checked like this

		$this->assertNull( $project->fresh() );
	}


	public function test_a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

		$this->actingAs($project->owner)
			->patch($project->path(), $attributes = [
				'notes' => 'Changed'
			]);

        $this->assertDatabaseHas('projects', $attributes);
    }


    public function test_a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
			->get($project->path())
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

	public function test_an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

	public function test_an_authenticated_user_cannot_delete_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->delete($project->path())
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


	public function test_it_can_invite_a_user()
	{
		$project = Project::factory()->create();

		$task = $project->invite($user = User::factory()->create());

		$this->assertTrue($project->members->contains($user));
	}
}
