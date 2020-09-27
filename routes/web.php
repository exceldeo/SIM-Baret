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
});

Route::resource('user','User\UserController');

Route::get('scan', function () {
    return view('dashboard.scan');
})->name('scan');

Route::get('detail_item/{id}', function ($id) {
    return view('dashboard.detail_item', ['id' => $id]);
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
        return view('dashboard.scan');
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
        Route::patch('{id_gudang}/edit', 'Gudang\GudangController@update')->name('update');
        Route::delete('{id_gudang}/delete', 'Gudang\GudangController@destroy')->name('delete');
    });

    Route::prefix('usulan_pemasukan')->name('usulan_pemasukan.')->group(function () {
        Route::get('', 'UsulanPemasukan\UsulanPemasukanController@index')->name('index');
        Route::post('store', 'UsulanPemasukan\UsulanPemasukanController@store')->name('store');
        Route::post('save', 'UsulanPemasukan\UsulanPemasukanController@save')->name('save');
        Route::delete('delete', 'UsulanPemasukan\UsulanPemasukanController@destroy')->name('delete');
    });

    Route::prefix('validasi')->name('validasi.')->group(function () {
        Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
            Route::get('', 'Validasi\ValidasiPemasukanController@index')->name('index');
            Route::get('{id_catatan}/show', 'Validasi\ValidasiPemasukanController@show')->name('show');
            Route::post('save', 'Validasi\ValidasiPemasukanController@save')->name('save');
        });
    });

    Route::prefix('catatan')->name('catatan.')->group(function () {
        Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
            Route::get('', 'Catatan\CatatanPemasukanController@index')->name('index');
            Route::get('{id_catatan}/show', 'Catatan\CatatanPemasukanController@show')->name('show');
        });
    });

});

