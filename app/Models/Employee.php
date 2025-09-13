<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'puesto',
];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'contacto_emergencia' => 'array',
    ];

    // ✅ AGREGAR ESTA RELACIÓN NUEVA
    public function certificados(): HasMany
    {
        return $this->hasMany(Certificado::class);
    }

    // ... (tus otros métodos existentes)

}
