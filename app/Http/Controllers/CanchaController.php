<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;

class CanchaController extends Controller
{
    // Listar todas las canchas (home)
    public function index()
    {
        $canchas = Cancha::all();
        return view('home', compact('canchas'));
    }

    // Ver detalle de una cancha
    public function show(Cancha $cancha)
    {
        $torneos = $cancha->torneos;
        
        // Obtener solo horarios disponibles (sin reservas confirmadas hoy o en el futuro)
        $horariosReservados = Reserva::where('cancha_id', $cancha->id)
                                    ->where('estado', 'confirmada')
                                    ->where('fecha', '>=', now()->toDateString())
                                    ->pluck('horario_id')
                                    ->unique();
        
        $horarios = $cancha->horarios()
                        ->whereNotIn('id', $horariosReservados)
                        ->get();
        
        return view('canchas.show', compact('cancha', 'torneos', 'horarios'));
    }
}