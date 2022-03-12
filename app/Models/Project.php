<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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




    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }


}
