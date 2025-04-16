<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

Route::get('/show', [PostsController::class, 'show']);
Route::get('/', [PostsController::class, 'index']);
Route::get('/index', [PostsController::class, 'index']);

