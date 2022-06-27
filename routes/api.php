<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class)->except(['create', 'edit']);
Route::get('search', SearchController::class)->name('search');
