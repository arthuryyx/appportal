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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::resource('account', 'AccountController');

    Route::resource('appliance/ajax', 'ApplianceController@ajax');
    Route::resource('appliance', 'ApplianceController');

    Route::get('brand/{type}', 'BrandController@index');
    Route::resource('brand', 'BrandController',['except' => ['index', 'create', 'show']]);

    Route::get('category/{type}', 'CategoryController@index');
    Route::resource('category', 'CategoryController',['except' => ['index', 'create', 'show']]);

});

Route::group(['middleware' => 'auth', 'namespace' => 'Customer', 'prefix' => 'customer'], function() {
    Route::resource('individual', 'IndividualController');
    Route::resource('corporation', 'CorporationController');
    Route::get('address/create/{cid}', 'AddressController@create');
    Route::post('address', 'AddressController@store');
    Route::get('address/{id}/edit', 'AddressController@edit');
    Route::put('address/{id}', 'AddressController@update');

});

Route::group(['middleware' => 'auth', 'namespace' => 'Appliance', 'prefix' => 'appliance'], function() {
    Route::resource('invoice/job', 'JobController');
    Route::resource('invoice/bulk', 'BulkController');
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
    Route::post('stock/order', 'StockController@placeOrder');
    Route::post('stock/switch', 'StockController@switch');
    Route::post('stock/exchange', 'StockController@exchange');
    Route::post('stock/arrive', 'StockController@warehousing');
    Route::post('stock/release', 'StockController@release');
    Route::post('stock/deliver/{invoice}', 'StockController@delivery');
    Route::post('stock/merge', 'StockController@mergeOrders');
    Route::post('stock/display', 'StockController@display');
    Route::delete('stock/{id}', 'StockController@destroy');
    Route::get('stock/exportAvailable', 'StockController@exportAvailable');
    Route::get('stock/exportCheckingList', 'StockController@exportStockCheckingList');
    Route::get('deposit/index/{invoice}', 'DepositController@index');
    Route::post('deposit', 'DepositController@store');
    Route::get('delivery/index/{invoice}', 'DeliveryController@index');
    Route::get('delivery/packing-slip/{delivery}', 'DeliveryController@exportPackingSlip');
    Route::get('order/{invoice}', 'OrderController@index');
    Route::get('record/{type}', 'RecordController@index');

});

Route::group(['middleware' => 'auth', 'namespace' => 'Material', 'prefix' => 'material'], function() {
    Route::resource('attribute', 'AttributeTypeController');
    Route::get('attribute/value/{id}/edit', 'AttributeValueController@edit');
    Route::put('attribute/value/{id}', 'AttributeValueController@update', ['name' => 'value.update']);
    Route::resource('attribute/{id}/value', 'AttributeValueController', ['except' => ['index', 'edit', 'update', 'show', 'destroy']]);

    Route::resource('type', 'ItemTypeController', ['except' => ['destroy']]);

    Route::get('item/create/{tid}', 'ItemController@create');
    Route::resource('item', 'ItemController', ['except' => ['create', 'show', 'destroy']]);



});

Route::group(['middleware' => 'auth', 'namespace' => 'Kitchen', 'prefix' => 'kitchen'], function() {
    Route::resource('quot', 'QuotationController', ['except' => ['edit', 'update', 'destroy']]);
    Route::post('quot/select', 'QuotationController@selectProduct');
    Route::post('quot/select-ajax', 'QuotationController@selectAjax');
    Route::post('quot/approve', 'QuotationController@approve');
    Route::post('product/delete', 'QuotationController@deleteProduct');

    Route::get('job', ['as'=>'kitchen.job.index','uses'=>'JobController@index']);
    Route::get('job/create/{qid}', ['as'=>'kitchen.job.store','uses'=>'JobController@store']);
    Route::get('job/{id}', ['as'=>'kitchen.job.show','uses'=>'JobController@show']);

});

Route::group(['middleware' => 'auth', 'namespace' => 'Product', 'prefix' => 'product'], function() {
    Route::get('category-tree-view','CategoryController@manageCategory');
    Route::post('add-category',['as'=>'add.category','uses'=>'CategoryController@addCategory']);
    Route::post('select-ajax', 'CategoryController@selectAjax');

    Route::resource('part', 'PartController', ['except' => ['show', 'destroy']]);

    Route::resource('model', 'ModelController', ['except' => ['destroy']]);

});


Route::group(['middleware' => 'auth'], function() {
//    Route::get('tempstock/create', 'StockController@create');
//    Route::post('tempstock', 'StockController@store');
//    Route::get('tempstock/{id}/out', 'StockController@out');
//    Route::delete('tempstock/{id}', 'StockController@destroy');
//    Route::get('tempstock/exportAssigned', 'StockController@exportAssigned');

    Route::resource('contact/supplier', 'Contact\SupplierController');

    Route::get('statistics/salesLine', 'StatisticsController@salesLine');
    Route::get('statistics/salesBar', 'StatisticsController@salesBar');
    Route::get('statistics/personalBar', 'StatisticsController@personalBar');
    Route::get('statistics/salesChart', 'StatisticsController@salesChart');
    Route::get('statistics/sales', 'StatisticsController@applianceSalesTable');

    Route::get('settings', 'UserController@settings');
    Route::post('/settings/reset', 'UserController@reset');

    Route::get('select2-autocomplete-ajax/applianceModel', 'Select2AutocompleteController@applianceModel');
    Route::get('select2-autocomplete-ajax/productModel', 'Select2AutocompleteController@productModel');
    Route::get('select2-autocomplete-ajax/available', 'Select2AutocompleteController@available');
    Route::get('select2-autocomplete-ajax/unsigned', 'Select2AutocompleteController@unsigned');

});
