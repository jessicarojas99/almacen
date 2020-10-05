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
    return view('vendor/adminlte/auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/almacen', 'WarehouseController@index')->name('almacen');
Route::get('/almacen/lista', 'WarehouseController@list')->name('almacenList');
Route::post('/almacen/registro', 'WarehouseController@store')->name('almacenStore');
Route::get('/almacen/eliminar/{id}', 'WarehouseController@destroy')->name('almacenDelete');
Route::get('/almacen/editar/{id}', 'WarehouseController@edit')->name('almacenEdit');
Route::post('/almacen/actualizar', 'WarehouseController@update')->name('almacenUpdate');
