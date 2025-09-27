<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Mostrar el formulario de login para administradores
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    /**
     * Manejar el intento de login del administrador
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            // Verificar que el administrador esté activo
            $admin = Auth::guard('admin')->user();
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                throw ValidationException::withMessages([
                    'email' => ['La cuenta de administrador está desactivada.'],
                ]);
            }
            
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'))
                           ->with('success', 'Bienvenido al panel de administración');
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Cerrar sesión del administrador
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                       ->with('success', 'Sesión cerrada correctamente');
    }
}
