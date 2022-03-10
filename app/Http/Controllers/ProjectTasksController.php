<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProjectTasksController extends Controller
{
    public function store(Project $project) : RedirectResponse
    {
        if (auth()->user()->isNot($project->owner))
        {
            abort(403);
        }

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }


    public function update(Project $project, Task $task) : RedirectResponse
    {
		if (auth()->user()->isNot($project->owner))
        {
            abort(403);
        }

        request()->validate(['body' => 'required']);

		$task->update([
			'body' => request('body'),
			'completed' => request()->has('completed')
		]);

		return redirect($project->path());
    }


}
