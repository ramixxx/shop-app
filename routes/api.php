<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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

Route::get('/', [ProductController::class, 'getAllProducts']);

Route::post('/addProductToCart', [CartController::class, 'addProductToCart']);

Route::get('/getCartProducts', [CartController::class, 'getCartProducts']);

Route::get('/clearCartProducts', [CartController::class, 'clearCartProducts']);

Route::post('/manageProductQuantity', [CartController::class, 'manageProductQuantity']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});