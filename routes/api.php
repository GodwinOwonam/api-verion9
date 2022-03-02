<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/sort', [ProductController::class, 'sortProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);


Route::post('/products/search/', [ProductController::class, 'search']);
Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/{id}', [ProductController::class, 'edit']);


Route::delete('/products/{id}', [ProductController::class, 'destroy']);


// Product category routes
// get routes
Route::get('/product-categories', [ProductCategoryController::class, 'index']);


// post routes
Route::post('/product-categories/store', [ProductCategoryController::class, 'store']);