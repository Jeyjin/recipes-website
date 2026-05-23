<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Главная
Route::get('/', [PageController::class, 'home'])->name('home');

// О нас
Route::get('/about', [PageController::class, 'about'])->name('about');

// Меню
Route::get('/menu', [ProductController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [ProductController::class, 'show'])->name('product.show');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Авторизация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Только для авторизованных
Route::middleware('auth')->group(function () {
    Route::get('/order', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/profile', [OrderController::class, 'profile'])->name('profile');
    Route::post('/profile', [OrderController::class, 'updateProfile'])->name('profile.update');
    Route::get('/repeat-order/{id}', [OrderController::class, 'repeatOrder'])->name('order.repeat');
});

// Мероприятия
Route::get('/events', [PageController::class, 'events'])->name('events');

// Контакты
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

// Отзывы (пользователи)
Route::get('/reviews', [\App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Админка
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::get('stat', [\App\Http\Controllers\Admin\StatController::class, 'index'])->name('stat');
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
Route::post('reviews/{id}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
Route::post('reviews/{id}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
Route::delete('reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
});