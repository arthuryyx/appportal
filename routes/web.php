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
    Route::resource('region', 'RegionController');

    Route::get('model/barcode', function () {return view('admin.appliance.barcode');});
    Route::put('model/barcode', 'ApplianceController@barcode');
    Route::get('appliance/model', function () {return view('admin.appliance.show');});

    Route::get('model/importExport', 'ApplianceController@importExport');
//    Route::get('model/downloadExcel/{type}', 'ApplianceController@downloadExcel');
    Route::post('model/importExcel', 'ApplianceController@importExcel');

    Route::resource('appliance/ajax-index', 'ApplianceController@ajaxIndex');
    Route::resource('appliance', 'ApplianceController');

    Route::get('brand/{type}', 'BrandController@index');
    Route::resource('brand', 'BrandController',['except' => ['index', 'create', 'show']]);

    Route::get('category/{type}', 'CategoryController@index');
    Route::resource('category', 'CategoryController',['except' => ['index', 'create', 'show']]);

});

Route::group(['middleware' => 'auth', 'namespace' => 'Kitchen', 'prefix' => 'kitchen'], function() {


    Route::resource('product/brand', 'Kitchen_Product_Brand_Controller',['except' => ['create', 'show']]);
    Route::resource('product/category', 'Kitchen_Product_Category_Controller',['except' => ['create', 'show']]);
    Route::resource('product/template', 'Kitchen_Product_Template_Controller');
    Route::resource('product/item', 'Kitchen_Product_Item_Controller',['except' => ['index', 'show'], 'as' => 'kitchen']);
    Route::resource('job/quote', 'Kitchen_Job_Quote_Controller',['except' => ['destroy'], 'as' => 'kitchen' ]);

    Route::post('board/arriving', 'Kitchen_Board_Order_Controller@arriving');
    Route::get('board/arrived', 'Kitchen_Board_Stock_Controller@arrived');
    Route::get('board/ajax-arrived', 'Kitchen_Board_Stock_Controller@ajaxArrived');

    Route::get('board/usage', 'Kitchen_Board_Stock_Controller@usage');
    Route::get('board/ajax-usage', 'Kitchen_Board_Stock_Controller@ajaxUsage');
    Route::post('board/usage', 'Kitchen_Board_Stock_Controller@uses');


    Route::get('board/stock/ajax-index', 'Kitchen_Board_Stock_Controller@ajaxIndex');
    Route::resource('board/stock', 'Kitchen_Board_Stock_Controller',['except' => ['show', 'edit', 'update', 'destroy'], 'as' => 'board']);

    Route::get('board/order/pending', 'Kitchen_Board_Order_Controller@pending');
    Route::get('board/order/ajax-pending', 'Kitchen_Board_Order_Controller@ajaxPending');

    Route::get('board/order/item/{id}', 'Kitchen_Board_Order_Controller@edit');
    Route::post('board/order/item/{id}', 'Kitchen_Board_Order_Controller@update');

    Route::post('board/order/item', 'Kitchen_Board_Order_Controller@itemStore');
    Route::get('board/order/ajax-index', 'Kitchen_Board_Order_Controller@ajaxIndex');
    Route::resource('board/order', 'Kitchen_Board_Order_Controller',['except' => ['edit', 'update', 'destroy'], 'as' => 'board']);
    Route::get('board/name-select2', 'Kitchen_Board_Stock_Controller@getIdByName');

});

Route::group(['middleware' => 'auth', 'namespace' => 'Appliance', 'prefix' => 'appliance'], function() {
    Route::resource('quote', 'QuoteController');
    Route::get('quote/{id}/html', 'QuoteController@quoteHtml');

    Route::resource('invoice/job', 'JobController');
    Route::post('unpaid/index/{uid}', 'JobController@unpaidList');
    Route::get('invoice/ajax-index', 'JobController@ajaxIndex');
    Route::post('invoice/paid', 'JobController@paid');
    Route::get('invoice/job/{id}/html', 'StockController@invoiceHtml');
    Route::get('cid/{id}', 'JobController@cidToJob');

    Route::get('aircon', function () {return view('appliance.invoice.job.index');});
    Route::get('ajax-index', 'AirConController@airConIndex');


    Route::post('item/create', 'ItemController@store');
    Route::get('item/{id}/edit', 'ItemController@edit');
    Route::patch('item/{id}', 'ItemController@update');
    Route::get('stock/ajaxIndex/{state}', 'StockController@ajaxIndex');
    Route::get('stock/index/{state}', 'StockController@index');
//    Route::post('stock/job/assign', 'StockController@assign');
    Route::post('stock/allocation', 'StockController@allocation');
    Route::post('stock', 'StockController@store');
    Route::get('stock/{aid}/detail', 'StockController@detail');
    Route::get('stock/listing', 'StockController@listing');
    Route::get('stock/{id}/edit', 'StockController@edit');
    Route::post('stock/restock', 'StockController@restock');
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
    Route::get('deposit/{id}/edit', 'DepositController@edit');
    Route::patch('deposit/{id}', 'DepositController@update');
    Route::get('deposit/pending', 'DepositController@pending');
    Route::post('deposit/confirm/{id}', 'DepositController@confirm');

    Route::get('record/{type}', 'RecordController@index');

    Route::get('job/order/{id}', 'OrderController@jobOrders');
    Route::get('order/ajax-index', 'OrderController@ajaxIndex');
    Route::post('order/confirm', 'OrderController@confirmOrder');
    Route::post('order/merge', 'OrderController@mergeOrders');
    Route::post('order/append', 'OrderController@append');
    Route::resource('order', 'OrderController', ['except' => ['destroy']]);

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
    Route::get('statistics/salesArea', 'StatisticsController@salesArea');

    Route::get('statistics/sales', 'StatisticsController@applianceSalesTable');
    Route::post('statistics/sales', 'StatisticsController@applianceSalesTable');

    Route::post('statistics/payment/{id}', 'StatisticsController@paymentChart');
    Route::get('statistics/payment', 'StatisticsController@payment');
    Route::post('statistics/payment', 'StatisticsController@payment');

    Route::get('select2-autocomplete-ajax/applianceModel', 'Select2AutocompleteController@applianceModel');
    Route::get('select2-autocomplete-ajax/activeModel', 'Select2AutocompleteController@activeModel');
    Route::get('select2-autocomplete-ajax/availableModel', 'Select2AutocompleteController@availableModel');
    Route::get('select2-autocomplete-ajax/productModel', 'Select2AutocompleteController@productModel');
    Route::get('select2-autocomplete-ajax/available', 'Select2AutocompleteController@available');
    Route::get('select2-autocomplete-ajax/unsigned', 'Select2AutocompleteController@unsigned');
    Route::get('select2-autocomplete-ajax/existOrder', 'Select2AutocompleteController@existOrder');
    Route::get('select2-autocomplete-ajax/kitchen/template', 'Select2AutocompleteController@kitchenTemplate');

});
