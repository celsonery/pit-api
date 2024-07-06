<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::get('/me', [AuthController::class, 'me'])
    ->middleware('auth:sanctum')
    ->name('me');

Route::get('/oauth/{provider}', [AuthController::class,'redirectToProvider']);
Route::get('/oauth/{provider}/callback', [AuthController::class,'handleProviderCallback']);
