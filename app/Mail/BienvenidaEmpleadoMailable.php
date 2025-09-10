<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BienvenidaEmpleadoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;

    public function __construct(Employee $empleado)
    {
        $this->empleado = $empleado;
    }

    public function build()
    {
        return $this->subject('🎉 Bienvenido a la empresa')
            ->view('emails.bienvenida_empleado')
            ->with([
                'empleado' => $this->empleado,
            ]);
    }
}
