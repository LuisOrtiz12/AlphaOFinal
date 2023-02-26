<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactanosPublicos extends Model
{
    use HasFactory;
    protected $fillable=['nombre','apellido','correo','puesto','contactanos'];
}
