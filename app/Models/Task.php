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
		$this->recordActivity('completed_task'); // move the activity feed update to this method instead of boot
	}

	public function incomplete() : void
	{
		$this->update(['completed' => false]);
		$this->recordActivity('incompleted_task'); // move the activity feed update to this method instead of boot
	}

		/**
	 * Insert a new row for each activity to the table activities
	 *
	 * @param string $activity
	 * @return void
	 */
	public function recordActivity($description) : void
	{
		$this->activity()->create([
			'description' => $description,
			'project_id' => $this->project_id
		]);
	}

	public function activity()
	{
		return $this->morphMany(Activity::class, 'subject')->latest();
	}
}
