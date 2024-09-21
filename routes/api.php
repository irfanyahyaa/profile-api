<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::get( '/unauthenticated', [ProfileController::class, 'unauthenticated'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/profile', ProfileController::class);
});
