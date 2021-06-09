<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\User\UserController;
use App\Http\Controllers\v1\User\Projects\UserProjectController;
use App\Http\Controllers\v1\User\Projects\UserProjectRelationController;

Route::apiResource('/', UserController::class);

Route::prefix('/{user}')->group(function () {
    Route::prefix('/relationships')->group(function () {
        Route::prefix('/projects')->group(function () {
            Route::get('/', [UserProjectRelationController::class, 'index'])->name('users.relationships.projects');
            Route::patch('/', [UserProjectRelationController::class, 'update'])->name('users.relationships.projects');
        });
        Route::prefix('/comments')->group(function () {
            Route::get('/', [UserCommentRelationController::class, 'index'])->name('users.relationships.comments');
            Route::patch('/', [UserCommentRelationController::class, 'update'])->name('users.relationships.comments');
        });
    });

    Route::get('/projects', [UserProjectController::class, 'index'])->name('users.projects');
    Route::get('/comments', [UserCommentController::class, 'index'])->name('users.comments');
});
