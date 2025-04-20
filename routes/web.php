<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index']);
Route::get('/index', [PostController::class, 'index']);
Route::get('/show', [PostController::class, 'show']); 
Route::resource('posts', PostController::class);


