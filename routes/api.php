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
    require(__DIR__ . '/api/users.php');
    require(__DIR__ . '/api/me.php');
    // require(__DIR__ . '/api/account_types.php');
    // require(__DIR__ . '/api/accounts.php');
    // require(__DIR__ . '/api/teams.php');
    // require(__DIR__ . '/api/projects.php');
    // require(__DIR__ . '/api/tasks.php');
    // require(__DIR__ . '/api/comments.php');
});
