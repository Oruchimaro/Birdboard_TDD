<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Project;
use App\Observers\TaskObserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Project::observe(ProjectObserver::class);  // Register model observer for Project model
		Task::observe(TaskObserver::class);  // Register model observer for Task model
    }
}
