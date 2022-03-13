<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;

class ProjectTasksController extends Controller
{
    public function store(Project $project) : RedirectResponse
    {
		$this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }


	public function update(Project $project, Task $task) : RedirectResponse
	{
		$this->authorize('update', $task->project);

		request()->validate(['body' => 'required']);

		$task->update([ 'body' => request('body') ]);

		if (request()->has('completed'))
		{
			$task->complete();
		}

		return redirect($project->path());
	}
}
