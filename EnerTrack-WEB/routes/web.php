<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard']);

Route::get('/calculator', [App\Http\Controllers\PageController::class, 'calculator']);

Route::get('/analysis', [App\Http\Controllers\PageController::class, 'analysis']);

Route::get('/history', [App\Http\Controllers\PageController::class, 'history']);
