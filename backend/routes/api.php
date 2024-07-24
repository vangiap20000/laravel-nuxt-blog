<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'users']);

    Route::post('/logout', [LoginController::class, 'logout']);
    // http://127.0.0.1:8000/api/tasks/
    Route::group(['prefix'=>'tasks'], function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::put('/{task}', [TaskController::class, 'update']);
        Route::delete('/{task}', [TaskController::class, 'destroy']);
        Route::get('/status', [TaskStatusController::class, 'index']);
        Route::post('/move', [TaskController::class, 'handelMove']);
    });

    Route::resource('projects', ProjectController::class);
    Route::group(['prefix'=>'projects-task/{projectId}', 'middleware' => 'checkProject'], function () {
        Route::get('/', [ProjectTaskController::class, 'index']);
        Route::post('/', [ProjectTaskController::class, 'store']);
        Route::put('/{projectTask}', [ProjectTaskController::class, 'update']);
        Route::delete('/{projectTask}', [ProjectTaskController::class, 'destroy']);
        Route::post('/move', [ProjectTaskController::class, 'handelMove']);
    });
});

Route::post('login', [LoginController::class, 'handleLogin']);
Route::post('register', [RegisterController::class, 'handleRegister']);
Route::post('reset-password', [ResetPasswordController::class, 'handelReset']);