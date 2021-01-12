<?php
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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes(['register' => false]);
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::group( ['namespace' => 'Vendor', 'prefix' => 'vendor', 'as' => 'vendor.', 'middleware' => []], function () {
        
    Route::get('get', ['uses' =>'VendorController@get'])->name('get');
    Route::post('register', ['uses' =>'VendorController@register'])->name('register');
    Route::get('list', ['uses' =>'VendorController@list'])->name('list');
    Route::post('edit/{id}', ['uses' =>'VendorController@edit'])->name('edit');
    Route::delete('delete/{id}', ['uses' =>'VendorController@delete'])->name('delete');
    Route::post('assign/{id}/{client}', ['uses' =>'VendorController@assign'])->name('assign');    
});


Route::group( ['namespace' => 'Client', 'prefix' => 'client', 'as' => 'client.', 'middleware' => []], function () {
        
    Route::get('get', ['uses' =>'ClientController@get'])->name('get');
    Route::get('get_id/{id}', ['uses' =>'ClientController@get_id'])->name('get_id');
    Route::post('register/{id}', ['uses' =>'ClientController@register'])->name('register');
    Route::get('list', ['uses' =>'ClientController@list'])->name('list');
    Route::get('edit/{id}', ['uses' =>'ClientController@edit'])->name('edit');
    Route::delete('delete/{id}', ['uses' =>'ClientController@delete'])->name('delete');
    Route::get('type', ['uses' =>'ClientController@type'])->name('type');
    Route::get('type_list', ['uses' =>'ClientController@type_list'])->name('type_list');
    Route::post('type_register', ['uses' =>'ClientController@type_register'])->name('type_register');
    Route::post('type_edit/{id}', ['uses' =>'ClientController@type_edit'])->name('type_edit');
    Route::delete('type_delete/{id}', ['uses' =>'ClientController@type_delete'])->name('type_delete');
    Route::get('question_list/{id}/{bol}', ['uses' =>'ClientController@question_list'])->name('question_list');
    Route::get('question_register/{id}/{question}', ['uses' =>'ClientController@question_register'])->name('question_register');
    Route::get('question_edit/{id}/{question}', ['uses' =>'ClientController@question_edit'])->name('question_edit');
    Route::delete('question_delete/{id}', ['uses' =>'ClientController@question_delete'])->name('question_delete');
    Route::get('all_question_client/{id}', ['uses' =>'ClientController@all_question_client'])->name('all_question_client');
      
});

Route::group( ['namespace' => 'Product', 'prefix' => 'product', 'as' => 'product.', 'middleware' => []], function () {
        
    Route::get('get', ['uses' =>'ProductController@get'])->name('get');
    Route::post('register', ['uses' =>'ProductController@register'])->name('register');
    Route::get('list', ['uses' =>'ProductController@list'])->name('list');
    Route::post('edit/{id}', ['uses' =>'ProductController@edit'])->name('edit');
    Route::delete('delete/{id}', ['uses' =>'ProductController@delete'])->name('delete');
        
});

Route::group( ['namespace' => 'Sale', 'prefix' => 'sale', 'as' => 'sale.', 'middleware' => []], function () {
        
    Route::get('report', ['uses' =>'SaleController@report'])->name('report');
    
        
});


