<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // ici on utilise la vue dashboard.blade.php
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('recipes', RecipeController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('recipes', RecipeController::class);
});


Route::middleware(['auth'])->group(function () {

    Route::get('/favorites', [RecipeController::class, 'favorites'])
        ->name('recipes.favorites');

    Route::post('/recipes/{recipe}/favorite', [RecipeController::class, 'toggleFavorite'])
        ->name('recipes.favorite');

});

require __DIR__.'/auth.php';
