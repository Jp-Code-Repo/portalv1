<?php

use App\Http\Controllers\Api\Identity\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authenticated user route

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// User routes

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::post('/{id}/restore', 'restore');
    });