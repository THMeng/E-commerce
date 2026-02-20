<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\frontend\HomeController;
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

Route::post('/signin',                 [UserController::class, 'userLoginApi']);
Route::post('/signup',[UserController::class,'signupApi']);

Route::middleware(['auth:sanctum','admin'])->group( function () {
    Route::get('/get-user', [UserController::class, 'getUser']);


    Route::get('/admin/list-category', [CategoryController::class, 'listCategory']);


    Route::get('/admin/list-product', [ProductController::class, 'listProduct']);
    Route::post('/admin/add-product', [ProductController::class, 'addProductApi']);
});


