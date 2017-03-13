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

//    Route::resource('project', 'ProjectController');
//    Route::get('project/{pid}/downloadpdf/', 'ProjectController@generateDeliveryList');
//    Route::get('project/{pid}/appliance/', 'ProjectApplianceRecordController@create');

    Route::resource('material/board', 'BoardController');

});
Route::group(['middleware' => 'auth', 'namespace' => 'Appliance', 'prefix' => 'appliance'], function() {
    Route::resource('invoice/job', 'JobController');
    Route::resource('invoice/bulk', 'BulkController');
    Route::get('stock/index/{state}', 'StockController@index');
    Route::post('stock/job/assign', 'StockController@assign');
    Route::post('stock', 'StockController@store');
    Route::get('stock/{aid}/detail', 'StockController@detail');
    Route::get('stock/{id}/edit', 'StockController@edit');
    Route::put('stock/{id}', 'StockController@update');
    Route::get('stock/exportAvailable', 'StockController@exportAvailable');
    Route::get('stock/exportCheckingList', 'StockController@exportStockCheckingList');

});


Route::group(['middleware' => 'auth'], function() {
    Route::get('tempstock/create', 'StockController@create');
    Route::post('tempstock', 'StockController@store');
    Route::get('tempstock/{id}/out', 'StockController@out');
    Route::delete('tempstock/{id}', 'StockController@destroy');
    Route::get('tempstock/exportAssigned', 'StockController@exportAssigned');

    Route::get('settings', 'UserController@settings');
    Route::post('/settings/reset', 'UserController@reset');

    Route::get('select2-autocomplete-ajax/applianceModel', 'Select2AutocompleteController@applianceModel');
    Route::get('select2-autocomplete-ajax/available', 'Select2AutocompleteController@available');

});
