<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use App\Models\Horario;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Mostrar formulario de reserva
public function create(Request $request)
{
    $cancha_id = $request->query('cancha_id');
    $canchas = Cancha::all();
    $horarios = Horario::all();
    
    // Obtén las reservas confirmadas (para validar en frontend)
    $reservasConfirmadas = Reserva::where('estado', 'confirmada')
                                   ->get()
                                   ->groupBy(function($item) {
                                       return $item->cancha_id . '-' . $item->fecha . '-' . $item->horario_id;
                                   });
    
    return view('reservas.create', compact('canchas', 'horarios', 'cancha_id', 'reservasConfirmadas'));
}

    // Guardar reserva
public function store(Request $request)
{
    // Validar datos
    $validated = $request->validate([
        'usuario_id' => 'required|exists:usuarios,id',
        'cancha_id' => 'required|exists:canchas,id',
        'horario_id' => 'required|exists:horarios,id',
        'fecha' => 'required|date|after_or_equal:today',
        'cantidad_jugadores' => 'required|integer|min:1|max:11',
    ], [
        'usuario_id.required' => 'Debes estar registrado',
        'usuario_id.exists' => 'Usuario no válido',
        'cancha_id.required' => 'Debes seleccionar una cancha',
        'cancha_id.exists' => 'Cancha no válida',
        'horario_id.required' => 'Debes seleccionar un horario',
        'horario_id.exists' => 'Horario no válido',
        'fecha.required' => 'La fecha es obligatoria',
        'fecha.after_or_equal' => 'La fecha no puede ser en el pasado',
        'cantidad_jugadores.required' => 'La cantidad de jugadores es obligatoria',
        'cantidad_jugadores.min' => 'Mínimo 1 jugador',
        'cantidad_jugadores.max' => 'Máximo 11 jugadores',
    ]);

    // Validar que el horario no esté reservado ese día
    $reservaExistente = Reserva::where('cancha_id', $validated['cancha_id'])
                                ->where('horario_id', $validated['horario_id'])
                                ->where('fecha', $validated['fecha'])
                                ->where('estado', 'confirmada')
                                ->first();

    if ($reservaExistente) {
        return back()->withInput()->withErrors(['horario' => 'Este horario ya está reservado para esa fecha']);
    }

    // Obtener el día de la semana
    $fecha_obj = new \DateTime($validated['fecha']);
    $diaSemanaNumero = $fecha_obj->format('w');
    $diasSemana = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
    $diaSemana = $diasSemana[$diaSemanaNumero];

    // Obtener el horario
    $horario = Horario::find($validated['horario_id']);

    // Validar que el horario exista para ese día
    if (strtolower($horario->dia_semana) !== strtolower($diaSemana)) {
        return back()->withInput()->withErrors(['horario' => 'Este horario no está disponible para el día seleccionado']);
    }

    // Crear reserva
    $reserva = Reserva::create($validated);

    return redirect()->route('reservas.show', $reserva->id)
                   ->with('success', 'Reserva confirmada exitosamente');
}

    // Ver detalle de reserva
    public function show(Reserva $reserva)
    {
        $usuario = $reserva->usuario;
        $cancha = $reserva->cancha;
        $horario = $reserva->horario;

        return view('reservas.show', compact('reserva', 'usuario', 'cancha', 'horario'));
    }

    // Cancelar reserva
    public function destroy(Reserva $reserva)
    {
        $reserva->update(['estado' => 'cancelada']);

        return back()->with('success', 'Reserva cancelada');
    }
}