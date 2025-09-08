<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Barryvdh\DomPDF\Facade\Pdf;

class Certificado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'tipo_certificado', 
        'numero_certificado',
        'titulo',
        'contenido',
        'fecha_emision',
        'fecha_vencimiento',
        'estado',
        'template',
        'datos_adicionales',
        'firma_digital_path',
        'sello_path',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'datos_adicionales' => 'array',
    ];

    // ✅ Relación con empleado
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // ✅ Relación con usuario creador
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Relación con usuario actualizador
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ✅ crear certificado metodo
    public function generarPdf()
    {
        $pdf = Pdf::loadView('certificados.pdf', [
            'certificado' => $this
        ]);

        return $pdf;

    }

    // ✅ Método para el nombre del archivo PDF
    public function getNombrePdfAttribute()
    {
        // Aseguramos que el empleado exista
        $nombreEmpleado = $this->employee ? str_replace(' ', '_', strtolower($this->employee->nombre)) : 'sin-nombre';

        return 'certificado-' . $nombreEmpleado . '-' . $this->numero_certificado . '-' . now()->format('Ymd-His') . '.pdf';
    }

    // ✅ Scope para certificados vencidos
    public function scopeVencidos($query)
    {
        return $query->where('estado', 'Vencido');
    }

    // ✅ Scope para certificados activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }
}