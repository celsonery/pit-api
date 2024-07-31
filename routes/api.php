<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
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
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider'])->name('oauth.redirect');
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('oauth.callback');
});
