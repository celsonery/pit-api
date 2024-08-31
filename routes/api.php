<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DeliveryMethodController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\StoreController;
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

Route::apiResource('/segments', SegmentController::class);
Route::apiResource('/companies', CompanyController::class);
Route::apiResource('/brands', BrandController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/addresses', AddressController::class);
Route::apiResource('/deliveries', DeliveryMethodController::class);
Route::apiResource('/images', ImageController::class);
Route::apiResource('/orders', OrderController::class)->only(['index', 'store']);
Route::apiResource('/payments', PaymentMethodController::class);
Route::apiResource('/phones', PhoneController::class);
Route::apiResource('/stores', StoreController::class);
