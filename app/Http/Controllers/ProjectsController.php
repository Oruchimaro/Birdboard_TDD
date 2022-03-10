<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }


    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner))  //Eloquent models provide *is* & *isNot* methods, checks to see 2 models are equal or not equal
        {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }


    public function create()
    {
        return view('projects.create');
    }



    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }
}
