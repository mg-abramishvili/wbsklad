<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserCatalogTableColumnController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\NomenclatureController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('login', [AuthController::class, 'login']);
Route::post('registration', [AuthController::class, 'registration']);
Route::post('me', [AuthController::class, 'me']);
Route::get('user-verify/{key}', [AuthController::class, 'verify']);

// USER
Route::get('user', [UserController::class, 'user']);
Route::put('user/update', [UserController::class, 'update']);

// CATALOG
Route::get('user-catalog-table-columns', [UserCatalogTableColumnController::class, 'index']);
Route::put('user-catalog-table-columns', [UserCatalogTableColumnController::class, 'update']);

// PRODUCTS
Route::get('products', [ProductController::class, 'index']);
Route::get('products/wildberries/load', [ProductController::class, 'wildberriesLoad']);

// CONTRACTORS
Route::get('contractors', [ContractorController::class, 'index']);
Route::get('contractor/{uid}', [ContractorController::class, 'contractor']);
Route::post('contractors', [ContractorController::class, 'store']);
Route::put('contractor/{uid}/update', [ContractorController::class, 'update']);
Route::delete('contractor/{uid}/delete', [ContractorController::class, 'delete']);

// NOMENCLATURES
Route::get('nomenclatures', [NomenclatureController::class, 'index']);
Route::get('nomenclature/{uid}', [NomenclatureController::class, 'nomenclature']);
Route::post('nomenclatures', [NomenclatureController::class, 'store']);
Route::post('nomenclatures/import', [NomenclatureController::class, 'import']);
Route::put('nomenclature/{uid}/update', [NomenclatureController::class, 'update']);