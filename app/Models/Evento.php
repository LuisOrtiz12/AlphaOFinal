<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $fillable=['id','titulo','imagen','descripcion','evento','contacto','cupos'];

    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }
}
