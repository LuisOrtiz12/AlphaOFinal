<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ira extends Model
{
    use HasFactory;
    protected $fillable=['Tema','descripcion','video'];

}
