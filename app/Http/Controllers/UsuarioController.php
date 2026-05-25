<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'documento' => 'required|string|unique:usuarios,documento',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'numero.required' => 'El número es obligatorio',
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);
        // Crear usuario
        $usuario = Usuario::create($validated);
        // Redirigir al dashboard del usuario
        return redirect()->route('login')
                   ->with('success', 'Registro exitoso. Inicia sesión');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        $reservas = $usuario->reservas;
        return view('usuarios.show', compact('usuario', 'reservas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
