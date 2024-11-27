<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\SocialAccountController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('register.activate');
    Route::post('/password/create', [PasswordResetController::class, 'create'])->name('password.reset.create');
    Route::get('/password/find/{token}', [PasswordResetController::class, 'find'])->name('password.reset.find');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.reset');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/user', [AuthController::class, 'user'])->name('auth.user');
    });
});

Route::group(['prefix' => 'oauth'], function () {
    Route::get('/{provider}', [SocialAccountController::class, 'redirectToProvider'])->name('oauth.redirect');
    Route::get('/{provider}/callback', [SocialAccountController::class, 'handleProviderCallback'])->name('oauth.callback');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/products/favorites', FavoritesController::class)
        ->except(['show', 'update'])
        ->names('favorites');

    Route::apiResource('/orders', OrderController::class)
        ->only(['index', 'store', 'show'])
        ->names('orders');

    Route::put('/user', [UserController::class, 'update'])->name('user.update');
});

Route::apiResource('/products', ProductController::class)->names('products');
