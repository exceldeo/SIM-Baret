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
    return view('dashboard.index');
    // return redirect()->route('login');
})->name('index');

Route::get('scan', function () {
    return view('dashboard.scan');
})->name('scan');

Route::get('detail_item/{id}', function ($id) {
    return view('dashboard.detail_item', ['id' => $id]);
})->name('detail_item');

/* END Temporary route */

Route::get('login', 'User\UserController@login')->name('login');
Route::post('authenticate', 'User\UserController@authenticate')->name('authenticate');

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index')->middleware('auth');

    Route::get('logout', 'User\UserController@logout')->name('logout');

    Route::get('scan', function () {
        return view('dashboard.scan');
    })->name('scan')->middleware('auth');

});

Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('', 'Barang\BarangController@index')->name('index');


});