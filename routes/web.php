<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', [TaskController::class, 'index'])->name('home');

Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');

Route::post('/tasks/update-order', [TaskController::class, 'updateOrder'])->name('tasks.update-order');

Route::resource('tasks', TaskController::class);
Route::resource('projects', ProjectController::class);