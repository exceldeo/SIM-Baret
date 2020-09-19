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

/* Temporary route for static UI */
Route::get('/', function () {
    // return view('dashboard.index');
    return redirect()->route('dashboard.index');
})->name('index');

Route::get('scan', function () {
    return view('dashboard.barcode.index');
})->name('scan');

Route::get('detail_item/{id}', function ($id) {
    return view('dashboard.barang.view', ['id' => $id]);
})->name('detail_item');

/* END Temporary route */

Route::get('login', 'User\UserController@login')->name('login');
Route::post('authenticate', 'User\UserController@authenticate')->name('authenticate');

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index');

    Route::get('logout', 'User\UserController@logout')->name('logout');

    Route::get('scan', function () {
        return view('dashboard.barcode.index');
    })->name('scan');

    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('', 'Barang\BarangController@index')->name('index');
    });
    
    Route::prefix('gudang')->name('gudang.')->group(function () {
        Route::get('', 'Gudang\GudangController@index')->name('index');
        Route::get('create', 'Gudang\GudangController@create')->name('create');
        Route::get('{id_gudang}/edit', 'Gudang\GudangController@edit')->name('edit');
        Route::get('{id_gudang}/show', 'Gudang\GudangController@show')->name('show');
        Route::post('store', 'Gudang\GudangController@store')->name('store');
        Route::patch('{id_gudang}/edit', 'Gudang\GudangController@update');
        Route::delete('{id_gudang}/delete', 'Gudang\GudangController@destroy')->name('delete');
    });

});
