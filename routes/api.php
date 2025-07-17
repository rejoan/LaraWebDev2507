<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('auth/login', [AuthController::class, 'createToken']);
Route::group(['prefix' => 'auth','middleware' => 'auth:sanctum'], function () {
    Route::get('me', [AuthController::class, 'authUser']);
    Route::post('logout', [AuthController::class, 'signOut']);
});
