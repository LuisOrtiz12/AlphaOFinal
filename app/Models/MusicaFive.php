<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicaFive extends Model
{
    use HasFactory;
    protected $fillable=['tema','genero','descripcion','duracion','imagen','audio'];
}
