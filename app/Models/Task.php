<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

	protected $casts = [ 'completed' => 'boolean' ];

	protected $touches = ['project']; // on update, update these relationships as well (updated at)

	protected static function boot()
	{
		parent::boot();

		static::created(function($task){
			$task->project->recordActivity('created_task');
		});
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}


	public function path() : string
	{
		return "/projects/{$this->project->id}/tasks/{$this->id}";
	}

	public function complete() : void
	{
		$this->update(['completed' => true]);
		$this->project->recordActivity('completed_task'); // move the activity feed update to this method instead of boot
	}

	public function incomplete() : void
	{
		$this->update(['completed' => false]);
		// $this->project->recordActivity('completed_task'); // move the activity feed update to this method instead of boot
	}
}
