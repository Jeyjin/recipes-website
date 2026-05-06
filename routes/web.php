<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Главная
Route::get('/', [RecipeController::class, 'index'])->name('home');
Route::post('/search', [RecipeController::class, 'search'])->name('search');

// Аутентификация
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Профиль и избранное
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/favorites/list', [RecipeController::class, 'getFavoritesList']);
    Route::post('/favorites/{id}', [RecipeController::class, 'addToFavorites']);
    Route::delete('/favorites/{id}', [RecipeController::class, 'removeFromFavorites']);
});

// Админка 
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{id}/role', [AdminController::class, 'changeRole']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
    Route::get('/recipes', [AdminController::class, 'recipes'])->name('admin.recipes');
    Route::get('/recipes/create', [AdminController::class, 'createRecipe'])->name('admin.recipes.create');
    Route::post('/recipes', [AdminController::class, 'storeRecipe'])->name('admin.recipes.store');
    Route::get('/recipes/{id}/edit', [AdminController::class, 'editRecipe'])->name('admin.recipes.edit');
    Route::put('/recipes/{id}', [AdminController::class, 'updateRecipe'])->name('admin.recipes.update');
    Route::delete('/recipes/{id}', [AdminController::class, 'deleteRecipe'])->name('admin.recipes.delete');
    Route::post('/recipes/{id}/image', [AdminController::class, 'uploadImage'])->name('admin.recipes.image');
});