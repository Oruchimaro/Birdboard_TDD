<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
	use RefreshDatabase;
    /**
     * Model Activity Tests
     */
    public function test_it_has_a_user()
    {
		$user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

		$this->assertEquals($user->id, $project->activity->first()->user->id );
    }
}
