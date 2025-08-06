<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('google/redirect', [App\Http\Controllers\Auth\ZkLoginController::class, 'redirectToGoogle']);
    Route::get('google/callback',  [App\Http\Controllers\Auth\ZkLoginController::class, 'handleGoogleCallback']);
    Route::post('zklogin/verify',   [App\Http\Controllers\Auth\ZkLoginController::class, 'verifyZkLogin'])
         ->middleware('auth:sanctum');
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('notes', App\Http\Controllers\NoteController::class)->except(['index']);
});

// zkLogin API
Route::post('/api/zklogin', [App\Http\Controllers\Auth\ZkLoginController::class, 'authenticate']);

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

