<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\FacturasController;
 use App\Http\Controllers\CartillaController;
use App\Http\Controllers\ApuntesController;
use App\Http\Controllers\RecibosController;


    
Route::get('/', function () {
    return view('auth.login');
});


Route::resource('clientes', ClientesController::class)->middleware('auth');

Route::resource('facturas', FacturasController::class)->middleware('auth');
Route::get('/facturas/cliente/{cliente_id}', [FacturasController::class, 'facturascliente']);

Route::resource('proveedores', ProveedoresController::class)->middleware('auth');

Route::resource('direcciones', DireccionesController::class)->middleware('auth');
Route::get('/clientes/{cliente_id}/direcciones', [DireccionesController::class, 'direccionescliente'])->name('clientes.direcciones');

Route::resource('cartilla',CartillaController::class)->middleware('auth');
Route::resource('apuntes',ApuntesController::class)->middleware('auth');
Route::get('/cartillas/{cartilla_id}/apuntes', [ApuntesController::class, 'apuntescartilla'])->name('cartillas.apuntes');



Route::resource('recibos',RecibosController::class)->middleware('auth');
Route::get('/generarRecibos', [RecibosController::class, 'generarRecibos'])->name('generarRecibos');
Route::get('/verRecibos', [RecibosController::class, 'verRecibos'])->name('verRecibos'); 
Route::get('/recibos/generar/{factura_id}', [RecibosController::class, 'generarRecibos'])->name('recibos.generar');
Route::get('/recibos/ver/{factura_id}', [RecibosController::class, 'verRecibos'])->name('verRecibos');

Auth::routes(['register' => true, 'reset' => true]); //si pongo false no puedo hacer olvidar conttrasena
//ahora hhaceme: En cada cartilla se podran insertar apuntes. Cada apunte tendra siguinte forma:(fecha,concepto,importe (el importe puede ser positivo o negativo , en funcion de  si se ingresa o retira dinero)) tambien haceme controlador


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');