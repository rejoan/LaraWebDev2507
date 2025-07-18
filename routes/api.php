<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HitController;

Route::post('auth/login', [AuthController::class, 'createToken']);
Route::get('/articles', [ArticleController::class, 'list']);
Route::get('/articles/public/{id}', [ArticleController::class, 'showPublic']);
Route::post('set/limit/minute', [HitController::class, 'perMin']);

Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
  Route::get('me', [AuthController::class, 'authUser']);
  Route::post('logout', [AuthController::class, 'signOut']);
});

Route::group(['prefix' => 'articles', 'middleware' => 'auth:sanctum'], function () {
  Route::post('/', [ArticleController::class, 'store']);
  Route::get('mine', [ArticleController::class, 'index']);
  Route::get('/{id}', [ArticleController::class, 'show']);
  Route::put('/{id}', [ArticleController::class, 'update']);
  Route::delete('/{id}', [ArticleController::class, 'destroy']);
});


Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {
  Route::get('/', [CategoryController::class, 'index']);
  Route::post('/', [CategoryController::class, 'store']);
  Route::put('/{id}', [CategoryController::class, 'update']);
  Route::delete('/{id}', [CategoryController::class, 'destroy']);
});