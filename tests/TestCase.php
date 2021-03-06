<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    /**
     * An alias for actingAs that adds a signedIn user to test case
     */
    protected function signIn($user = null)
    {
		$user = $user ?: User::factory()->create();

        $this->actingAs($user);

		return $user;
    }
}
