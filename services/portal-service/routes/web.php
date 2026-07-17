<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'portal',
    'namespace' => 'App\Http\Controllers',
], function () {

    Route::get('/', 'UserController@index');

});