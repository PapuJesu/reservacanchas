<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $table = 'canchas';
    protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud', 'embed_maps', 'telefono', 'email', 'informacion', 'reglas', 'fotos'];
    public function torneos()
    {
        return $this->hasMany(Torneo::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
