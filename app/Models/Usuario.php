<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['nombre', 'numero', 'documento', 'password'];
    protected $hidden = ['password'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    // Encriptar contraseña automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (isset($model->attributes['password'])) {
                $model->attributes['password'] = Hash::make($model->attributes['password']);
            }
        });
    }
}