<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 use App\Http\Controllers\ClientesController;


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

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 