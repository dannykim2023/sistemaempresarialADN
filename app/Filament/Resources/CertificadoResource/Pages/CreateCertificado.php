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

        // Generar el PDF
        $pdf = $certificado->generarPdf();

        // Obtener el correo del empleado
        $email = $certificado->employee->email ?? null;

        if ($email) {
            // Enviar correo con PDF adjunto
            Mail::to($email)->send(new CertificadoMailable($certificado, $pdf));
        }
    }
}
