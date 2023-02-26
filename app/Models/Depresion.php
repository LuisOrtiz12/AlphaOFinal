<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depresion extends Model
{
    use HasFactory;
    protected $fillable=['Tema','descripcion','video'];
}
