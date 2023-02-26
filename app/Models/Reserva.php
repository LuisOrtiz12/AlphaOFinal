<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $fillable=['state','numero','user_id','eventos_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function eventos()
    {
        return $this->belongsTo(Evento::class);
    }
}
