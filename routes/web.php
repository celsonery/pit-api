<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'The silence is gold!';
});

Route::group(['prefix' => 'oauth'], function () {
    Route::get('/{provider}', [AuthController::class, 'redirectToProvider'])->name('oauth.redirect');
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('oauth.callback');
});
