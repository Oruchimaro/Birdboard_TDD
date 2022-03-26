<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
	use HasFactory, RecordsActivity ;

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


	/**
	 * Invite a user to this project
	 *
	 * @param User $user
	 */
	public function invite($user)
	{
		return $this->members()->attach($user);
	}


	public function members()
	{
		return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
	}

	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}


	public function addTask($body) : Task
	{
		return $this->tasks()->create(compact('body'));
	}

	/**
	 * Create a relationship with activity for this model
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function activity()
	{
		return $this->hasMany(Activity::class)->latest();
	}
}
