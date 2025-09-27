<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClientLoginController extends Controller
{
    /**
     * Mostrar el formulario de login para clientes (página AirPods)
     */
    public function showLoginForm()
    {
        return view('auth.client.login');
    }

    /**
     * Mostrar el formulario de registro para clientes
     */
    public function showRegisterForm()
    {
        return view('auth.client.register');
    }

    /**
     * Manejar el intento de login del cliente
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true; // Solo clientes activos
        $credentials['role'] = 'cliente'; // Solo clientes

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('client.dashboard'))
                           ->with('success', 'Bienvenido a tu panel de cliente');
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden o la cuenta está desactivada.'],
        ]);
    }

    /**
     * Manejar el registro de un nuevo cliente
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
            'is_active' => true,
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('client.dashboard')
                       ->with('success', 'Cuenta creada exitosamente. ¡Bienvenido!');
    }

    /**
     * Cerrar sesión del cliente
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')
                       ->with('success', 'Sesión cerrada correctamente');
    }
}
