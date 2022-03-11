<?php

use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/me', [AuthController::class, 'me']);