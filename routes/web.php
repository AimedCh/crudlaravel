<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\AlquileresController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AirpodsPurchaseController;
use App\Http\Controllers\AirpodsOrderController;
use App\Http\Controllers\FacturaPDFController;
// OrdenController eliminado

// Ruta principal - redirige al login de cliente por defecto
Route::get('/', function () {
    return redirect()->route('client.login');
});

// Ruta de login por defecto (requerida por Laravel Auth)
Route::get('/login', function () {
    return redirect()->route('client.login');
})->name('login');

// Ruta de logout por defecto (redirige según el contexto)
Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    } elseif (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
        return redirect()->route('client.login');
    }
    return redirect()->route('client.login');
})->name('logout');

// ============================================================================
// RUTAS DE AUTENTICACIÓN PARA CLIENTES (Acceso a tienda AirPods)
// ============================================================================
Route::prefix('client')->name('client.')->group(function () {
    Route::get('login', [ClientLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [ClientLoginController::class, 'login']);
    Route::get('register', [ClientLoginController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [ClientLoginController::class, 'register']);
    Route::post('logout', [ClientLoginController::class, 'logout'])->name('logout');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN PARA ADMINISTRADORES (Acceso exclusivo al backend)
// ============================================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// ============================================================================
// RUTAS PROTEGIDAS PARA ADMINISTRADORES (Backend exclusivo)
// ============================================================================
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Dashboard principal
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestión de entidades (CRUD completo)
    Route::resource('proveedores', ProveedoresController::class);
    Route::resource('contacto', ContactoController::class);
    Route::get('mensajes', [AdminDashboardController::class, 'mensajes'])->name('mensajes');
    Route::get('reservas', [AdminDashboardController::class, 'reservas'])->name('reservas');
    Route::put('reservas/{reserva}', [AdminDashboardController::class, 'updateReserva'])->name('reservas.update');
    Route::delete('reservas/{reserva}', [AdminDashboardController::class, 'destroyReserva'])->name('reservas.destroy');
    Route::get('reservas/{reserva}/pdf', [AdminDashboardController::class, 'generatePDF'])->name('reservas.pdf');
    
    // Rutas para compras de AirPods
    Route::resource('airpods-purchases', AirpodsPurchaseController::class);
    Route::get('airpods-purchases/{airpodsPurchase}/pdf', [AirpodsPurchaseController::class, 'generatePDF'])->name('airpods-purchases.pdf');

    // Rutas adicionales para funcionalidad existente (eliminadas: facturas, recibos)

    // Gestión de mensajes
    Route::post('contacto/{contacto}/mark-replied', [ContactoController::class, 'markAsReplied'])->name('contacto.mark-replied');
    Route::post('contacto/{contacto}/mark-closed', [ContactoController::class, 'markAsClosed'])->name('contacto.mark-closed');

    // Generación de facturas PDF (eliminadas)
});

// Ruta pública para generar PDF de factura (eliminada)

// CSRF Token endpoint for React frontend
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf.token');

// ============================================================================
// RUTAS PÚBLICAS (Sin autenticación)
// ============================================================================

// CSRF Token para frontend React
Route::get('/backend/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// API Routes para frontend React (sin prefijo /api/) - Sin verificación CSRF
Route::prefix('backend')->withoutMiddleware(['csrf'])->group(function () {
    // Alquileres/Reservas
    Route::post('/alquileres/reserve', [AlquileresController::class, 'reserve'])->name('api.alquileres.reserve');
    Route::get('/alquileres/apartments', [AlquileresController::class, 'apiIndex'])->name('api.alquileres.index');

    // AirPods
    Route::get('/airpods/catalog', [AirpodsOrderController::class, 'catalog'])->name('api.airpods.catalog');
    Route::post('/airpods/order', [AirpodsOrderController::class, 'order'])->name('api.airpods.order');

    // Contacto
    Route::post('/contacto', [ContactoController::class, 'store'])->name('api.contacto.store');
});

Route::post('/backend/contacto/public', [ContactoController::class, 'store'])->name('contacto.public');
Route::post('/alquileres/reserve/public', [AlquileresController::class, 'reserve'])->name('alquileres.reserve.public');

// Rutas públicas para la tienda (eliminadas)

// ============================================================================
// RUTAS PROTEGIDAS PARA CLIENTES (Tienda AirPods)
// ============================================================================
Route::middleware('auth:web')->group(function () {
    // Dashboard del cliente (eliminado)

    // Tienda AirPods (eliminado)
    Route::post('/alquileres/reserve', [AlquileresController::class, 'reserve'])->name('alquileres.reserve');

    // Client orders management (eliminado)
    // Facturas para clientes (eliminado)
    // Generar factura para orden completada (eliminado)
});