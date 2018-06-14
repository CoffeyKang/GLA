<?php

use Illuminate\Http\Request;
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
// get inventory
Route::get('/inventory', 'InventoryController@index')->middleware('auth:api');
// make list
Route::get('/makes','MakeController@index');
// products list
Route::get('/product_list/{make}/{myCurrentPage}','InventoryController@product_list');
// single item
Route::get('/item/{item}','InventoryController@singleItem');
// realted items
Route::get('/related/{item}','InventoryController@related');

// get web banner
Route::get('/banner','BannerController@index');

// get web ads
Route::get('/ads','AdController@index');
// get feature products
Route::get('/featureProducts','InventoryController@featureProducts');

// get most popular products
Route::get('/popular','InventoryController@popularProducts');

// search items
Route::get('/searchResualt', 'InventoryController@searchResualt');

Route::get('/wishlist','ShoppingController@wishlist');

Route::post('/getItems_carts','InventoryController@getItems_carts');

/**
 * login
 */
Route::post('/loginCustomer','AccessControl@userinfo');

/** create new customer */
Route::post('/newCustomer','AccessControl@newCustomer');

// userdetails
Route::post('/userDetails','AccessControl@userDetails');

// remove from wishlist
Route::post('/removeFromWishlist','InventoryController@removeFromWishlist');

// add To wishlist
Route::post('/addToWishlist','InventoryController@addToWishlist');

//delete all wishlist
Route::post('/clearWishlist','InventoryController@clearWishlist');











