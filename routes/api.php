<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'as' => 'api.auth.'
], function () {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
});
Route::group(['middleware' => 'auth.jwt', 'as' => 'api.'], function () {
    Route::post('auth.logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
    Route::apiResource('tasks', \App\Http\Controllers\TaskController::class);
});
