<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\User\UserController;
use App\Http\Controllers\v1\User\UserRelatedController;

Route::apiResource('users', UserController::class);

Route::prefix('users')->group(function(){

    Route::prefix('/{userUuid}')->group(function () {

         // Get and manage model relationships
         Route::prefix('/relationships')->group(function () {
            Route::prefix('{relationship}')->group(function () {
                Route::get('/', [UserRelatedController::class, 'showResourceRelationships'])->name('users.relationships');
                Route::patch('/', [UserRelatedController::class, 'updateResourceRelationships'])->name('users.relationships');
            });
        });

        // View related models
        Route::get('{relationship}', [UserRelatedController::class, 'indexRelatedResources'])->name('users.related');

    });
});