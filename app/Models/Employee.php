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
        'tipo_contrato',
        'salario',       // <- debe estar
        'jornada',
        'fecha_inicio',
        'fecha_fin',
        'documento_path',
        'created_by',
        'updated_by',
        'area',
];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'contacto_emergencia' => 'array',
    ];
}
