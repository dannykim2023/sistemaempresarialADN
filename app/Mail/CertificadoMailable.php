<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Certificado;

class CertificadoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $certificado;
    public $pdf;

    public function __construct(Certificado $certificado, $pdf)
    {
        $this->certificado = $certificado;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Certificado emitido')
            ->view('emails.certificado') // Tu vista de correo
            ->attachData($this->pdf->output(), $this->certificado->nombre_pdf, [
                'mime' => 'application/pdf',
            ]);
    }
}
   