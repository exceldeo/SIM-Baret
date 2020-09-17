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
    return view('dashboard.index');
    // return redirect()->route('login');
});

Route::get('login', 'User\UserController@login')->name('login');
Route::post('authenticate', 'User\UserController@authenticate')->name('authenticate');

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index')->middleware('auth');

    Route::get('logout', 'User\UserController@logout')->name('logout');

});

Route::resource('user','User\UserController');
