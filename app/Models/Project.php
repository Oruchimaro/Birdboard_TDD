<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

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
		return $this->hasMany(Activity::class);
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
		$this->activity()->create(compact('description'));
	}
}
