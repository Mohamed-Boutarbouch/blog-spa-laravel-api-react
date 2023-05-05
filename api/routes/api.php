<?php

use App\Http\Controllers\ArticleController;
// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('dashboard/articles', ArticleController::class)->except(['index', 'show']);

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::get('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::get('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
