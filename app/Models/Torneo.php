<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $fillable = ['nombre', 'cancha_id'];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
