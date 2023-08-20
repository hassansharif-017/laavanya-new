<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/saveProductsData', [App\Http\Controllers\Api\ProductController::class, 'saveProductsData']);
Route::get('/editProductsData/{id}/edit', [App\Http\Controllers\Api\ProductController::class, 'editProductsData']);
Route::put('/editProductsData/{id}/edit', [App\Http\Controllers\Api\ProductController::class, 'updateProductsData']);