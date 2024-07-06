<?php

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::get('/me', [AuthController::class, 'me'])
    ->middleware('auth:sanctum')
    ->name('me');

//Route::get('/oauth/redirect', function () {
//    return Socialite::driver('github')->redirect();
//});
//
//Route::get('/oauth/callback', function () {
//    $githubUser = Socialite::driver('github')->stateless()->user();
//
//    $user = User::updateOfCreate([
//       'github_id' => $githubUser->id,
//    ],[
//        'name' => $githubUser->name,
//        'email' => $githubUser->email,
//        'github_token' => $githubUser->token,
//        'github_refresh_token' => $githubUser->refreshToken,
//    ]);
//
//    return Auth::login($user);
//
////    return redirect('/dashboard');
//});

Route::get('/oauth/{provider}', [AuthController::class,'redirectToProvider']);
Route::get('/oauth/{provider}/callback', [AuthController::class,'handleProviderCallback']);
