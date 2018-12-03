<?php

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

Route::get('/kang',"AccessControl@kang");

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test','inventoryController@test');

Auth::routes();

Route::get('/checkout', 'HomeController@index')->name('home');

Route::get('/admin','AdminController@index')->name('index');

Route::middleware(['auth','prevent-back-history'])->group(function () {
    
    Route::get('/home','AdminController@home');

    Route::get('/top10', 'AdminController@top10');

    Route::get('/orderHistory', 'AdminController@orderHistory');

    Route::get('/customerList', 'AdminController@customerList');

    Route::get('/pendingShipment', 'AdminController@pendingQuotes');

    Route::get('/pendingQuotes', 'AdminController@toBeQuotes');

    Route::get('/changePassword', 'AdminController@changePassword');

    Route::post('/updatePassword','AdminController@updatePassword');

    Route::get('/updateInfo','AdminController@updateInfo');

    Route::post('/updateInfo','AdminController@updateUser');

    Route::get('/dealerList','AdminController@dealerList');

    Route::get('/dealerList/{A}','AdminController@dealerListQuickSearch');

    Route::get('/dealerHistory','AdminController@dealerHistory');

    Route::get('/dealerHistory/{id}','AdminController@dealerHistory_oneDealer');

    Route::get('/dealerDetails/{id}','AdminController@dealerDetails');

    Route::get('/newDealer','AdminController@newDealer');

    Route::post('/newDealer','AdminController@storeDealer');
    
    Route::get('/editDealer/{id}','AdminController@editDealer');

    Route::post('/updateDealer/{id}','AdminController@updateDealer');

    Route::get('/uploadCatalog','AdminController@uploadCatalog');

    Route::get('/shippingOrder/{order_num}','AdminController@shippingOrder');

    Route::get('/QuoteOrder/{order_num}','AdminController@QuoteOrder');

    Route::post('/updateShipping','AdminController@updateShipping');

    Route::post('/updateQuote','AdminController@updateQuote');

    Route::get('/exchangeRate','AdminController@exchangeRate');
    
    Route::get('/updateExchangeRate','AdminController@updateExchangeRate');

    Route::post('/changeTaxRate','AdminController@changeTaxRate');

    Route::get('/featureProducts','AdminController@featureProducts');

    Route::post('/addNewFeatureProduct','AdminController@addNewFeatureProduct');

    Route::get('/deletefeatureItem/{id}','AdminController@deletefeatureItem');

    Route::get('/findDealer','AdminController@findDealer');

    Route::get('/findCustomer','AdminController@findCustomer');

    Route::get('/CustomerHistory/{id}','AdminController@CustomerHistory');

    Route::get('/oneOrder/{sono}','AdminController@oneOrder');

    Route::post('/updateDealerPass','AdminController@updateDealerPass');
});
