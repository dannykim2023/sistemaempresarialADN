<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'dni',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'contacto_emergencia',
        'avatar_path',
        'estado',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'contacto_emergencia' => 'array',
    ];
}
