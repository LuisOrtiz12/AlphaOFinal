<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;
    protected $fillable=['comentario','calificacion'];

    public function user() {
        return $this->belongsTo(User::class);
      }
}
