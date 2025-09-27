<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * EXCLUSIVIDAD: Solo administradores autenticados con guard 'admin' pueden acceder al backend.
     * Si un cliente intenta acceder, será redirigido inmediatamente.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si hay un administrador autenticado con el guard 'admin'
        if (!Auth::guard('admin')->check()) {
            // Si no hay administrador autenticado, redirigir al login de admin
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso no autorizado. Solo administradores.'], 401);
            }

            return redirect()->route('admin.login')->with('error', 'Acceso restringido. Solo administradores pueden acceder al backend.');
        }

        // Verificar que el usuario autenticado sea realmente un administrador activo
        $admin = Auth::guard('admin')->user();
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Cuenta de administrador desactivada.');
        }

        return $next($request);
    }
}
