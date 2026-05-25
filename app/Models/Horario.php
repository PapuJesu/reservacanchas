<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';
    protected $fillable = ['cancha_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'precio'];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
