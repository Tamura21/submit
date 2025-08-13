<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemotePostController;

Route::post('/remote-posts', [RemotePostController::class, 'store']);

