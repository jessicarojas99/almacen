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

Route::get('/consulta', 'ReportsController@index')->name('consultas');
Route::post('consulta-pdf', 'ReportsController@reportespdf')->name('pdf');
Route::get('/consultas', 'ReportsController@consulta')->name('consultasgral');
Route::get('/consultasdeposit', 'ReportsController@consultadeposito')->name('consultadeposit');
Route::get('/almacen/mostrar/{id}', 'WarehouseController@show')->name('almacenShow');

Route::get('/deposito', 'DepositController@index')->name('deposito');
Route::get('/deposito/lista', 'DepositController@list')->name('depositoList');
Route::post('/deposito/registro', 'DepositController@store')->name('depositoStore');
Route::get('/deposito/eliminar/{id}', 'DepositController@destroy')->name('depositoDelete');
Route::get('/deposito/editar/{id}', 'DepositController@edit')->name('depositoEdit');
Route::post('/deposito/actualizar', 'DepositController@update')->name('depositoUpdate');
Route::get('/deposito/mostrar/{id}', 'DepositController@show')->name('depositoShow');


Route::get('/comprobante', 'TicketController@index')->name('ticket');
Route::get('/comprobante/lista', 'TicketController@list')->name('ticketList');
Route::get('/comprobante/select/{id}', 'TicketController@itemSelected')->name('ticketItemSelect');
Route::post('/comprobante/registro', 'TicketController@store')->name('ticketStore');
Route::get('/comprobante/mostrar/{id}', 'TicketController@show')->name('ticketShow');

Route::get('/prestamo', 'ReceiptController@index')->name('receipt');
Route::get('/prestamo/lista', 'ReceiptController@list')->name('receiptList');
Route::get('/prestamo/select/{id}', 'ReceiptController@itemSelected')->name('receiptItemSelect');
Route::post('/prestamo/registro', 'ReceiptController@store')->name('receiptStore');
