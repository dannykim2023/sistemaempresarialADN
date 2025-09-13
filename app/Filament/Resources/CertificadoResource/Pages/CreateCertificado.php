<?php

namespace App\Filament\Resources\CertificadoResource\Pages;

use App\Filament\Resources\CertificadoResource;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\CertificadoMailable;
use Illuminate\Support\Facades\Mail;

class CreateCertificado extends CreateRecord
{
    protected static string $resource = CertificadoResource::class;

    /**
     * Después de crear un certificado, se ejecuta este método
     */
    protected function afterCreate(): void
        {
            $certificado = $this->record;

            // Generar el PDF para el empleado
            $pdf = $certificado->generarPdf();

            // Correo del empleado
            $emailEmpleado = $certificado->employee->email ?? null;

            if ($emailEmpleado) {
                // Enviar correo al empleado
                \Mail::to($emailEmpleado)->send(new \App\Mail\CertificadoMailable($certificado, $pdf));
            }

            // Enviar correo de notificación interna a admin
            $nombre = $certificado->employee->nombre ?? 'Desconocido';
            $cargo  = $certificado->employee->area ?? 'Desconocido';
            $fecha  = $certificado->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i');

            \Mail::html("
                <h2>Nuevo certificado creado</h2>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Cargo:</strong> {$cargo}</p>
                <p><strong>Fecha de emisión:</strong> {$fecha}</p>
            ", function ($message) {
                $message->to('danielosco88@gmail.com')
                        ->subject('Nuevo certificado creado');
            });
        }


}
