<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlquileresController;
use App\Http\Controllers\AirpodsOrderController;
use App\Http\Controllers\ContactoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// CSRF Token endpoint for frontend
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Public API routes for frontend React
Route::prefix('backend')->group(function () {
    // Alquileres/Reservas
    Route::post('/alquileres/reserve', [AlquileresController::class, 'reserve'])->name('api.alquileres.reserve');
    Route::get('/alquileres/apartments', [AlquileresController::class, 'apiIndex'])->name('api.alquileres.index');
    
    // AirPods
    Route::get('/airpods/catalog', [AirpodsOrderController::class, 'catalog'])->name('api.airpods.catalog');
    Route::post('/airpods/order', [AirpodsOrderController::class, 'order'])->name('api.airpods.order');
    
    // Contacto
    Route::post('/contacto', [ContactoController::class, 'store'])->name('api.contacto.store');
});

// Protected API routes (require authentication)
Route::middleware('auth:sanctum')->prefix('backend')->group(function () {
    // User orders (eliminado)
    Route::get('/user/reservations', [AlquileresController::class, 'userReservations'])->name('api.user.reservations');
});
