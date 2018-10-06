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
Route::get('/', 'HomeController@inicio');

Auth::routes();
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');



Route::group(['middleware' => 'auth'], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::resource('cuentas', 'CuentasController');
    Route::resource('cuentas-terceros', 'CuentasTercerosController');
    Route::get('/cuentas/terceros/cajero', 'CuentasTercerosController@mostrar_cajero')->name('cajero-externo');
    Route::post('/cuentas/terceros/transaccion', 'CuentasTercerosController@transaccion')->name('hacer-transaccion');
});

Route::group([
    'middleware' => ['auth', 'needsRole'],
    'is' => ['administrador'],
    'any' => true, //allow the access to the route when the user has at least one of the permissions
], function () {
    Route::resource('users', 'UsersController');
});

Route::group([
    'middleware' => ['auth', 'needsRole'],
    'is' => ['administrador', 'empleado'],
    'any' => true, //allow the access to the route when the user has at least one of the permissions
], function () {
    Route::resource('clientes', 'ClientesController');
    Route::resource('cuentas-externas', 'CuentasExternasController');

    Route::get('/cajero', 'CuentasController@mostrar_cajero')->name('cajero');
    Route::get('/listar/movimientos', 'CuentasController@listar_movimientos')->name('listar-movimientos');
    Route::post('/hacer/movimiento', 'CuentasController@transaccion')->name('hacer-movimiento');
});