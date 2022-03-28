<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProjectInvitationRequest;

class ProjectsInvitationsController extends Controller
{
	/**
	 * * Invite a user to a project
	 *
	 * @param Project $project
	 * @return void
	 */
	public function store(ProjectInvitationRequest $request,  Project $project) : RedirectResponse
	{
		$user = User::whereEmail($request->email)->first();

		$project->invite($user);

		return redirect($project->path());
	}
}
