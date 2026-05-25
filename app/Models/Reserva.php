<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = ['usuario_id', 'cancha_id', 'horario_id', 'fecha', 'cantidad_jugadores', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
