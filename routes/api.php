<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SidebarController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('{any}', function () {
//     return view('app');
// })->where('any', '.*');

Route::post('/login', [UserController::class, 'login']);
Route::post('/search', [ProductController::class, 'searchTerm']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/getAllProducts', [ProductController::class, 'getAllProducts']);

Route::post('/addProductToCart', [CartController::class, 'addProductToCart'])->middleware('auth:sanctum');

Route::get('/getCartProducts', [CartController::class, 'getCartProducts'])->middleware('auth:sanctum');

Route::get('/clearCartProducts', [CartController::class, 'clearCartProducts'])->middleware('auth:sanctum');

Route::post('/manageProductQuantity', [CartController::class, 'manageProductQuantity'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Left Sidebar
Route::post('/searchType', [ProductController::class, 'searchType']);
Route::get('/sidebarLinks', [SidebarController::class, 'allSidebarLinks']);
