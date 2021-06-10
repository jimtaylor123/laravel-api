<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\team\TeamController;
use App\Http\Controllers\v1\team\TeamRelatedController;

Route::apiResource('teams', TeamController::class);

Route::prefix('teams')->group(function(){

    // Route::get('relationships', [TeamRelatedController::class, 'indexRelationships']);

    Route::prefix('/{teamUuid}')->group(function () {

         // Get and manage model relationships
         Route::prefix('/relationships')->group(function () {
            Route::prefix('{relationship}')->group(function () {
                Route::get('/', [TeamRelatedController::class, 'showResourceRelationships'])->name('teams.relationships');
                Route::patch('/', [TeamRelatedController::class, 'updateResourceRelationships'])->name('teams.relationships');
            });
        });


        // View related models
        Route::get('{relationship}', [TeamRelatedController::class, 'indexRelatedResources'])->name('teams.related');

    });
});