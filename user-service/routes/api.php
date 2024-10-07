<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::put('users/info', [\App\Http\Controllers\AuthController::class, 'updateInfo']);
    Route::put('users/password', [\App\Http\Controllers\AuthController::class, 'updatePassword']);
});

Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);