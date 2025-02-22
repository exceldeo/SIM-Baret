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


/* END Temporary route */

Route::get('login', 'User\UserController@login')->name('login');
Route::get('/auth', 'User\UserController@authenticate')->name('auth');

Route::group(['middleware' => 'auth'], function () {
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
            Route::get('{id_barang}/detail', 'Barang\BarangController@show')->name('show');
            Route::patch('{id_barang}/edit', 'Barang\BarangController@update')->name('update');
            Route::post('validate', 'Barang\BarangController@validateScan')->name('validate');
            Route::get('{id_barang}/check','Barang\BarangController@check')->name('check');
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
    
        Route::prefix('usulan_penghapusan')->name('usulan_penghapusan.')->group(function () {
            Route::get('', 'UsulanPenghapusan\UsulanPenghapusanController@index')->name('index');
            Route::post('store', 'UsulanPenghapusan\UsulanPenghapusanController@store')->name('store');
            Route::post('save', 'UsulanPenghapusan\UsulanPenghapusanController@save')->name('save');
            Route::delete('delete', 'UsulanPenghapusan\UsulanPenghapusanController@destroy')->name('delete');
        });
    
        Route::prefix('validasi')->name('validasi.')->group(function () {
            Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
                Route::get('', 'Validasi\ValidasiPemasukanController@index')->name('index');
                Route::get('{id_catatan}/print', 'Validasi\ValidasiPemasukanController@print')->name('print');
                Route::get('{id_catatan}/show', 'Validasi\ValidasiPemasukanController@show')->name('show');
                Route::get('{id_catatan}/export', 'Validasi\ValidasiPemasukanController@export')->name('export');
                Route::post('save', 'Validasi\ValidasiPemasukanController@save')->name('save');
            });
            Route::prefix('penghapusan')->name('penghapusan.')->group(function () {
                Route::get('', 'Validasi\ValidasiPenghapusanController@index')->name('index');
                Route::get('{id_catatan}/print', 'Validasi\ValidasiPenghapusanController@print')->name('print');
                Route::get('{id_catatan}/show', 'Validasi\ValidasiPenghapusanController@show')->name('show');
                Route::post('save', 'Validasi\ValidasiPenghapusanController@save')->name('save');
                Route::prefix('unit')->name('unit.')->group(function () {
                    Route::get('', 'Validasi\ValidasiPenghapusanController@indexunit')->name('index');
                    Route::get('{id_catatan}/show', 'Validasi\ValidasiPenghapusanController@showunit')->name('show');
                    Route::post('save', 'Validasi\ValidasiPenghapusanController@saveunit')->name('save');
                });
            });
        });
        
        Route::prefix('surat')->name('surat.')->group(function () {
            Route::get('{id_catatan}', 'Surat\SuratController@index')->name('index');
            Route::get('{id_catatan}/log', 'Surat\SuratController@indexLog')->name('indexLog');
            Route::post('upload', 'Surat\SuratController@upload')->name('upload');
            Route::post('update', 'Surat\SuratController@update')->name('update');
        });
    
        Route::prefix('catatan')->name('catatan.')->group(function () {
            Route::prefix('pemasukan')->name('pemasukan.')->group(function () {
                Route::get('', 'Catatan\CatatanPemasukanController@index')->name('index');
                Route::get('{id_catatan}/show', 'Catatan\CatatanPemasukanController@show')->name('show');
                Route::get('{id_catatan}/print_barcode', 'Catatan\CatatanPemasukanController@print_barcode')->name('print_barcode');
            });
            Route::prefix('penghapusan')->name('penghapusan.')->group(function () {
                Route::get('', 'Catatan\CatatanPenghapusanController@index')->name('index');
                Route::get('{id_catatan}/show', 'Catatan\CatatanPenghapusanController@show')->name('show');
                Route::get('{id_catatan}/surat', 'Catatan\CatatanPenghapusanController@surat')->name('surat');
            });
        });
    
    });
});

