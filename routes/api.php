<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/me', [AuthController::class, 'me']);

// USER
Route::get('/user/{uid}', [UserController::class, 'user']);
Route::put('/user/{uid}/update', [UserController::class, 'update']);

// PRODUCTS
Route::get('user/{uid}/products', [ProductController::class, 'index']);
Route::get('user/{uid}/products/wildberries/load', [ProductController::class, 'wildberriesLoad']);