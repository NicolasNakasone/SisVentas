<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');

Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');

Route::resource('compras/ingreso','IngresoController');