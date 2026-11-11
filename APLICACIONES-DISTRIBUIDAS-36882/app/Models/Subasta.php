<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'precio_inicial',
        'precio_actual',
        'termina_en',
    ];
}


// No hice el inge estos cambios pero lei que es para una seguridad de datos