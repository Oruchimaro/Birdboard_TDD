<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

	protected $touches = ['project']; // on update, update these relationships as well (updated at)

	public function project()
	{
		return $this->belongsTo(Project::class);
	}


	public function path() : string
	{
		return "/projects/{$this->project->id}/tasks/{$this->id}";
	}


}
