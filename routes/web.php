<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

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

# API Routes
Route::group(['prefix' => 'api'], function () {
    Route::get('findProduct', 'ShopController@findProduct');
    Route::post('updateCart', 'ShopController@updateCart');
    Route::post('deleteItem', 'ShopController@deleteItem');
    Route::get('clearCart', 'ShopController@clearCart');
    Route::post('login', 'UserController@login');
    Route::put('addImage', 'ProductController@addImage');
    Route::post('addImage', 'ProductController@addImage');
    Route::post('removeImage', 'ProductController@removeImage');
    Route::get('logout', 'UserController@logout');
});

# Home Page
Route::get('/', 'PageController@index');

# Register Pages
Route::middleware(['userguard'])->group(function () {
    Route::get('/register', 'UserController@getRegister');
    Route::post('/register', 'UserController@postRegister');
});

# Account
Route::get('/account', 'UserController@account');
Route::post('/account', 'UserController@postAccount');

# Admin Console
Route::middleware(['adminguard'])->prefix('admin')->group(function () {
    Route::get('/', function() {
        return redirect('admin/products');
    });
    Route::get('/products/add-product', 'ProductController@create');
    Route::get('/categories/add-category', 'CategoryController@create');
    Route::get('/pages/add-page', 'PagesController@create');
    Route::get('/orders', 'AdminController@orders');
    Route::resource('/products', 'ProductController', ['except'=> ['create', 'show']]);
    Route::resource('/categories', 'CategoryController', ['except'=> ['create', 'show']]);
    Route::resource('/pages', 'PagesController', ['except'=> ['create', 'show']]);
});

# Shopping Cart Page
Route::get('/cart', 'ShopController@cart');

Route::group(['prefix' => 'shop'], function () {
    # Category list Page
    Route::get('/categories', 'ShopController@categories');

    # Shopping Cart Page
    Route::get('/cart', 'ShopController@cart');

    # Checkout
    Route::get('/checkout', 'ShopController@checkout');

    # Individual categories page
    Route::get('/{category}', 'ShopController@category');

    # Product page
    Route::get('/{category}/{product}', 'ShopController@product');
});

Route::get('/{page}', 'PageController@showPage');
