<?php

use App\Http\Controllers\Api\Identity\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
|
| Laravel default route. We'll revisit this once the authentication
| foundation is implemented.
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });