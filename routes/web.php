<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    Route::controller(ProjectsController::class)->group(function(){
        Route::get('/projects', 'index')->name('projects.index');
        Route::get('/projects/create', 'create')->name('projects.create');
        Route::get('/projects/{project}', 'show')->name('projects.show');
        Route::post('/projects', 'store')->name('projects.store');
    });

    Route::controller(ProjectTasksController::class)->group(function(){
        Route::post('/projects/{project}/tasks', 'store')->name('task.store');
        Route::patch('/projects/{project}/tasks/{task}', 'update')->name('task.update');
    });


    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

