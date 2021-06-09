<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\User\UserController;
use App\Http\Controllers\v1\User\Projects\UserProjectController;
use App\Http\Controllers\v1\User\Projects\UserProjectRelationController;

Route::apiResource('/', MeController::class)->only(['show', 'update']);
