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

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::resource('account', 'AccountController');

    Route::get('model/barcode', function () {return view('admin.appliance.barcode');});
    Route::put('model/barcode', 'ApplianceController@barcode');
//    Route::resource('appliance/ajax', 'ApplianceController@ajax');
    Route::get('appliance/model', function () {return view('admin.appliance.show');});
    Route::resource('appliance', 'ApplianceController');

    Route::get('brand/{type}', 'BrandController@index');
    Route::resource('brand', 'BrandController',['except' => ['index', 'create', 'show']]);

    Route::get('category/{type}', 'CategoryController@index');
    Route::resource('category', 'CategoryController',['except' => ['index', 'create', 'show']]);

});

Route::group(['middleware' => 'auth', 'namespace' => 'Appliance', 'prefix' => 'appliance'], function() {
    Route::resource('invoice/job', 'JobController');
    Route::post('invoice/paid', 'JobController@paid');
    Route::get('invoice/job/{id}/html', 'StockController@invoiceHtml');
    Route::get('stock/index/{state}', 'StockController@index');
//    Route::post('stock/job/assign', 'StockController@assign');
    Route::post('stock/allocation', 'StockController@allocation');
    Route::post('stock', 'StockController@store');
    Route::get('stock/{aid}/detail', 'StockController@detail');
    Route::get('stock/listing', 'StockController@listing');
    Route::get('stock/{id}/edit', 'StockController@edit');
    Route::post('stock/reentry', 'StockController@reentry');
    Route::put('stock/{id}', 'StockController@update');
    Route::get('stock/{id}/price', 'StockController@editPrice');
    Route::put('stock/{id}/price', 'StockController@updatePrice');
    Route::post('stock/order/{invoice}', 'StockController@placeOrder');
    Route::post('stock/switch', 'StockController@switchStock');
    Route::post('stock/exchange', 'StockController@exchange');
    Route::post('stock/arrive', 'StockController@warehousing');
    Route::post('stock/release', 'StockController@release');
    Route::post('stock/deliver/{invoice}', 'StockController@delivery');
    Route::post('stock/display', 'StockController@display');
    Route::post('stock/delete', 'StockController@delete');
    Route::get('stock/exportAvailable', 'StockController@exportAvailable');
    Route::get('stock/exportCheckingList', 'StockController@exportStockCheckingList');
    Route::get('deposit/index/{invoice}', 'DepositController@index');
    Route::post('deposit', 'DepositController@store');
    Route::get('record/{type}', 'RecordController@index');

    Route::get('job/order/{id}', 'OrderController@jobOrders');
    Route::resource('order', 'OrderController', ['except' => ['destroy']]);
    Route::post('order/confirm', 'OrderController@confirmOrder');
    Route::post('order/merge', 'OrderController@mergeOrders');

    Route::get('delivery/index/{invoice}', 'DeliveryController@index');
    Route::get('delivery/packing-slip/{delivery}', 'DeliveryController@exportPackingSlip');
    Route::post('delivery/request/{invoice}', 'DeliveryController@requestDelivery');
//    Route::get('delivery/request/{id}/edit', 'DeliveryController@editDispatch');
//    Route::put('delivery/request/{id}', 'DeliveryController@updateDispatch');

    Route::get('schedule', 'DispatchController@requestList');


});

Route::group(['middleware' => 'auth'], function() {

    Route::get('settings', 'UserController@settings');
    Route::post('/settings/reset', 'UserController@reset');

    Route::get('statistics/salesLine', 'StatisticsController@salesLine');
    Route::get('statistics/salesBar', 'StatisticsController@salesBar');
    Route::get('statistics/personalBar', 'StatisticsController@personalBar');
    Route::get('statistics/salesChart', 'StatisticsController@salesChart');
    Route::get('statistics/sales', 'StatisticsController@applianceSalesTable');
    Route::post('statistics/sales', 'StatisticsController@applianceSalesTable');

    Route::get('select2-autocomplete-ajax/applianceModel', 'Select2AutocompleteController@applianceModel');
    Route::get('select2-autocomplete-ajax/activeModel', 'Select2AutocompleteController@activeModel');
    Route::get('select2-autocomplete-ajax/availableModel', 'Select2AutocompleteController@availableModel');
    Route::get('select2-autocomplete-ajax/productModel', 'Select2AutocompleteController@productModel');
    Route::get('select2-autocomplete-ajax/available', 'Select2AutocompleteController@available');
    Route::get('select2-autocomplete-ajax/unsigned', 'Select2AutocompleteController@unsigned');

});
