<?php

use App\Http\Controllers\backend\AccessUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\AttributeController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CategoriesController;
use App\Http\Controllers\backend\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Home
Route::get('/',             [HomeController::class, 'Home']);
Route::get('/shop',         [HomeController::class, 'Shop']);
Route::get('/cart-item',         [HomeController::class, 'CartItem']);
Route::get('/my-order',         [HomeController::class, 'myOrder']);
Route::get('/view-order/{id}',         [HomeController::class, 'viewOrder']);
Route::get('/cancel-order/{id}',         [HomeController::class, 'cancelOrder']);
Route::get('/recipt',         [HomeController::class, 'recipt']);
Route::get('/check-out',         [HomeController::class, 'checkOut']);
Route::post('/place-order',         [HomeController::class, 'placeOrder']);
Route::get('/remove-cartitem/{id}',         [HomeController::class, 'RemoveCartItems']);
Route::post('/add-cart',         [HomeController::class, 'AddCart']);
Route::get('/product/{slug}',      [HomeController::class, 'Product']);
Route::get('/news',         [HomeController::class, 'News']);
Route::get('/article',      [HomeController::class, 'Article']);
Route::get('/search',       [HomeController::class, 'Search']);
Route::get('/404',       [HomeController::class, 'notFound']);
Route::get('/logout/{id}',[HomeController::class,'logout']);


// User SignIn & SignUp
Route::get('/signin',         [UserController::class, 'Signin'])->name('login');
Route::post('/signin-submit', [UserController::class, 'SigninSubmit']);

Route::get('/signup',         [UserController::class, 'Signup']);
Route::post('/signup-submit', [UserController::class, 'SignupSubmit']);

Route::get('/admin', [HomeController::class, 'isAdmin'])->middleware('admin');
Route::get('/guest', [HomeController::class, 'isGuest']);

// @Middleware Auth
 Route::middleware(['admin'])->group(function () {

    Route::get('/admin',             [AdminController::class, 'index']);
    Route::get('/admin/add-post',    [AdminController::class, 'AddPost']);
    Route::get('/admin/list-post',   [AdminController::class, 'ListPost']);

    // Sign Out
    Route::get('/admin/signout',     [UserController::class, 'signOut']);


    //add logo
    Route::get('/admin/add-logo',               [AdminController::class, 'addLogo']);
    Route::post('/admin/add-logo-submit',       [AdminController::class, 'addLogoSubmit']);
    Route::get('/admin/list-logo',              [AdminController::class, 'listLogo']);
    Route::get('/admin/update-logo/{id}',       [AdminController::class, 'updateLogo']);
    Route::post('/admin/update-logo-submit',    [AdminController::class, 'updateLogoSubmit']);
    Route::post('/admin/remove-logo-submit',    [AdminController::class, 'removeLogoSubmit']);

    //Log Activity
    Route::get('/admin/log-activity',           [AdminController::class, 'listLogActivity']);
    Route::get('/admin/log-detail/{post}/{id}/{ids}',           [AdminController::class, 'logDetail']);

    // Category
    Route::get('/admin/add-category',           [CategoriesController::class, 'addCategory']);
    Route::get('/admin/list-category',           [CategoriesController::class, 'listCategory']);
    Route::post('/admin/add-category-submit',    [CategoriesController::class, 'addCategorySubmit']);
    Route::get('/admin/update-cate/{id}',       [CategoriesController::class, 'updateCategory']);
    Route::post('/admin/update-category-submit',    [CategoriesController::class, 'updateCategorySubmit']);
    Route::post('/admin/remove-cate-submit',    [CategoriesController::class, 'removeCategorySubmit']);

    // Attribute
    Route::get('/admin/add-attribute',           [AttributeController::class, 'addAttribute']);
    Route::post('/admin/add-attribute-submit',   [AttributeController::class, 'addAttributeSubmit']);
    Route::get('/admin/list-attribute',              [AttributeController::class, 'listAttribute']);
    Route::get('/admin/update-attribute/{id}',       [AttributeController::class, 'updateAttribute']);
    Route::post('/admin/update-attribute-submit',    [AttributeController::class, 'updateAttributeSubmit']);
    Route::post('/admin/remove-attribute-submit',    [AttributeController::class, 'removeAttributeSubmit']);


    // Product
    Route::get('/admin/list-product',           [ProductController::class, 'listProduct']);
    Route::get('/admin/add-product',            [ProductController::class, 'addProduct']);
    Route::post('/admin/add-product-submit',    [ProductController::class, 'addProductSubmit']);
    Route::get('/admin/update-product/{id}',    [ProductController::class, 'updateProduct']);
    Route::get('/admin/detail-product/{id}',    [ProductController::class, 'detailProduct']);
    Route::post('/admin/update-product-submit',    [ProductController::class, 'updateProductSubmit']);
    Route::post('/admin/remove-product-submit',    [ProductController::class, 'removeProductSubmit']);

    // Access Order 
    Route::get('/admin/view-order',    [AccessUserController::class, 'accessOrder']);
    Route::get('/admin/access-order/{id}',    [AccessUserController::class, 'accessSubmit']);
    Route::get('/admin/list-order',[AccessUserController::class,'listOrder']);
    Route::post('/admin/reject-submit',[AccessUserController::class,'rejectOrder']);
 });
