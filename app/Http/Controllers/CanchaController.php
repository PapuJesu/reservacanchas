<?php

namespace App\Http\Controllers;

use App\Models\Cancha;

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
        $horarios = $cancha->horarios;
        
        return view('canchas.show', compact('cancha', 'torneos', 'horarios'));
    }
}