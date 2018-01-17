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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// get inventory
Route::get('/inventory', 'InventoryController@index');
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
