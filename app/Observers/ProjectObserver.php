<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
	{
		$this->recordActivity('created', $project);
	}


    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
	public function updated(Project $project)
	{
		$this->recordActivity('updated', $project);
	}


	/**
	 * Insert a new row for each activity to the table activities
	 *
	 * @param \App\Models\Project $project
	 * @param string $activity
	 * @return void
	 */
	protected function recordActivity($type, $project) : void
	{
		Activity::create([
			'project_id' => $project->id,
			'description' => $type
		]);
	}
}
