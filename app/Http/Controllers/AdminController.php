<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Horario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Listar canchas
    public function index()
    {
        $canchas = Cancha::all();
        return view('admin.canchas.index', compact('canchas'));
    }

    // Formulario crear cancha
    public function create()
    {
        return view('admin.canchas.create');
    }

    // Guardar cancha
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'latitud' => 'nullable|string',
        'longitud' => 'nullable|string',
        'embed_maps' => 'nullable|string',
        'informacion' => 'required|string',
        'reglas' => 'required|string',
        'fotos.*' => 'image|max:2048',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email',
    ], [
        'nombre.required' => 'El nombre es obligatorio',
        'direccion.required' => 'La dirección es obligatoria',
        'informacion.required' => 'La información es obligatoria',
        'reglas.required' => 'Las reglas son obligatorias',
        'fotos.*.image' => 'Las fotos deben ser imágenes',
    ]);

    // Procesar fotos
    $fotos = [];
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store('canchas', 'public');
            $fotos[] = $path;
        }
    }

    $validated['fotos'] = json_encode($fotos);

    Cancha::create($validated);

    return redirect()->route('admin.canchas.index')
                   ->with('success', 'Cancha creada exitosamente');
}

    // Formulario editar cancha
    public function edit(Cancha $cancha)
    {
        $fotos = json_decode($cancha->fotos, true) ?? [];
        return view('admin.canchas.edit', compact('cancha', 'fotos'));
    }

    // Actualizar cancha
    public function update(Request $request, Cancha $cancha)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'latitud' => 'nullable|string',
        'longitud' => 'nullable|string',
        'embed_maps' => 'nullable|string',
        'informacion' => 'required|string',
        'reglas' => 'required|string',
        'fotos.*' => 'image|max:2048',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email',
    ]);

    // Procesar fotos
    $fotos = json_decode($cancha->fotos, true) ?? [];
    
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store('canchas', 'public');
            $fotos[] = $path;
        }
    }

    $validated['fotos'] = json_encode($fotos);

    $cancha->update($validated);

    return redirect()->route('admin.canchas.index')
                   ->with('success', 'Cancha actualizada exitosamente');
}

    // Eliminar cancha
    public function destroy(Cancha $cancha)
    {
        $cancha->delete();

        return back()->with('success', 'Cancha eliminada exitosamente');
    }

    // Gestionar horarios de una cancha
    public function horarios(Cancha $cancha)
    {
        $horarios = $cancha->horarios;
        return view('admin.horarios.index', compact('cancha', 'horarios'));
    }

    // Crear horario para cancha
    public function crearHorario(Cancha $cancha)
    {
        return view('admin.horarios.create', compact('cancha'));
    }

    // Guardar horario
    public function guardarHorario(Request $request, Cancha $cancha)
    {
        $validated = $request->validate([
            'dia_semana' => 'required|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'precio' => 'required|integer|min:1000',
        ], [
            'dia_semana.required' => 'El día es obligatorio',
            'dia_semana.in' => 'El día no es válido',
            'hora_inicio.required' => 'La hora de inicio es obligatoria',
            'hora_fin.required' => 'La hora de fin es obligatoria',
            'hora_fin.after' => 'La hora de fin debe ser después de la hora de inicio',
            'precio.required' => 'El precio es obligatorio',
            'precio.min' => 'El precio mínimo es $1.000',
        ]);

        $validated['cancha_id'] = $cancha->id;

        Horario::create($validated);

        return redirect()->route('admin.horarios', $cancha->id)
                    ->with('success', 'Horario creado exitosamente');
    }

    // Eliminar horario
    public function eliminarHorario(Horario $horario)
    {
        $cancha_id = $horario->cancha_id;
        $horario->delete();

        return redirect()->route('admin.horarios', $cancha_id)
                       ->with('success', 'Horario eliminado exitosamente');
    }
}