<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Me\MeController;

Route::get('me', [MeController::class, 'show']);
Route::patch('me', [MeController::class, 'update']);
