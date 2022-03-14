<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

	public $old = [];

    /**
     * Return the path to a instance of Project
     * @param int $id  Project ID
     * @return string path
     */
    public function path($id = null) : string
    {
        return "/projects/" . ($id ?? $this->id);
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

	public function activity()
	{
		return $this->hasMany(Activity::class)->latest();
	}


    public function addTask($body) : Task
    {
        return $this->tasks()->create(compact('body'));
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
			'changes' => $this->activityChanges($description)
		]);
	}

	protected function activityChanges($description)
	{
		if ($description == 'updated')
		{
			return [
				'before' => Arr::except( array_diff($this->old, $this->getAttributes()) , 'updated_at'),
				'after' => Arr::except( $this->getChanges(), 'updated_at')
			];
		}
	}
}
