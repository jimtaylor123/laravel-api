<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Redirect request to /api to json version information
Route::get('/', [AppController::class, 'version']); 

// Version 1
Route::middleware('auth:api')->prefix('v1')->group(function(){
    Route::prefix('/me')->group(__DIR__ . '/api/me.php');
    Route::prefix('/accountTypes')->group(__DIR__ . '/api/account_types.php');
    Route::prefix('/accounts')->group(__DIR__ . '/api/accounts.php');
    Route::prefix('/users')->group(__DIR__ . '/api/users.php');
    Route::prefix('/teams')->group(__DIR__ . '/api/teams.php');
    Route::prefix('/projects')->group(__DIR__ . '/api/projects.php');
    Route::prefix('/tasks')->group(__DIR__ . '/api/tasks.php');
    Route::prefix('/comments')->group(__DIR__ . '/api/comments.php');
});
