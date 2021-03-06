<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }


    public function show(Project $project)
    {
		$this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }


    public function create()
    {
        return view('projects.create');
    }


	public function edit(Project $project)
	{
		return view('projects.edit', compact('project'));
	}



    public function store() : mixed
    {
        $project = auth()->user()->projects()->create(request()->validate([
			'title' => 'sometimes|required',
            'description' => 'sometimes|required',
			'notes' => 'nullable'
		]));

		if($tasks = request('tasks'))
		{
			$project->addManyTasks($tasks);
		}

		if(request()->wantsJson())
		{
			return ['message' => $project->path()];
		}

        return redirect($project->path());
    }


	public function update(UpdateProjectRequest $request, Project $project)
	{
		$project->update($request->validated());

		return redirect($project->path());
	}


	public function destroy(Project $project)
	{
		$this->authorize('manage', $project);

		$project->delete();

		return redirect('/projects');
	}

}
