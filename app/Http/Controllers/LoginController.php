<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'documento' => 'required|string',
            'password' => 'required|string',
        ], [
            'documento.required' => 'El documento es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        // Buscar usuario por documento
        $usuario = Usuario::where('documento', $validated['documento'])->first();

        // Verificar si existe y contraseña es correcta
        if (!$usuario || !Hash::check($validated['password'], $usuario->password)) {
            return back()->withInput()->withErrors(['login' => 'Documento o contraseña incorrectos']);
        }

        // Crear sesión
        session(['usuario_id' => $usuario->id]);
        session(['usuario_nombre' => $usuario->nombre]);

        return redirect()->route('home')
                    ->with('success', 'Sesión iniciada correctamente');
    }

    // Logout
    public function logout()
    {
        session()->flush();

        return redirect()->route('login')
                       ->with('success', 'Sesión cerrada');
    }
}