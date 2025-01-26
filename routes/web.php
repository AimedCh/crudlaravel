<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\LineasFacturasController;

Route::get('/', function () {
    return view('auth.login');
});
/*
Route::get('/clientes', function () {
return view('clientes.index');

});

Route::get('/clientes/create', function (){
return view('clientes.create');

});

Route::get('/clientes/edit', function () {
return view('clientes.edit');

});

Route::get('/clientes/form', function () {
    return view('clientes.form');
    
});
*/

/*
Route::get('/clientes', [ClientesController::class, 'index']);
Route::get('/clientes/create', [ClientesController::class, 'create']);
Route::get('/clientes/edit', [ClientesController::class, 'edit']);
Route::get('/clientes/form', [ClientesController::class, 'form']);
*/

Route::resource('clientes', ClientesController::class)->middleware('auth');
Route::resource('facturas', FacturasController::class)->middleware('auth');
Route::resource('proveedores', ProveedoresController::class)->middleware('auth');
Route::resource('lineasfacturas', LineasFacturasController::class)->middleware('auth');

Route::get('/facturas/cliente/{cliente_id}', [FacturasController::class, 'facturascliente']);


Auth::routes(['register' => true, 'reset' => true]); //si pongo false no puedo hacer olvidar conttrasena
 
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 