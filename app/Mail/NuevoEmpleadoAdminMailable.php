<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoEmpleadoAdminMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;

    public function __construct(Employee $empleado)
    {
        $this->empleado = $empleado;
    }

    public function build()
    {
        return $this->subject('🔔 Nuevo empleado registrado')
            ->view('emails.nuevo_empleado_admin')
            ->with([
                'empleado' => $this->empleado,
            ]);
    }
}
