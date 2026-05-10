<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('todos.index');
});

/*
|--------------------------------------------------------------------------
| Todo CRUD Routes
|--------------------------------------------------------------------------
*/

// Resource Routes
Route::resource('todos', TodoController::class);

/*
|--------------------------------------------------------------------------
| Custom Routes
|--------------------------------------------------------------------------
*/

// Mark Todo as Completed
Route::patch(
    '/todos/{id}/complete',
    [TodoController::class, 'markCompleted']
)->name('todos.complete');

// Restore Soft Deleted Todo
Route::patch(
    '/todos/{id}/restore',
    [TodoController::class, 'restore']
)->name('todos.restore');
