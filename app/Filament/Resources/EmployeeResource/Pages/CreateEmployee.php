<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail; // 👈 ESTE ES EL CORRECTO
use App\Mail\NuevoEmpleadoAdminMailable;
use App\Mail\BienvenidaEmpleadoMailable;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function afterCreate(): void
    {
        $empleado = $this->record;

        // 📩 Enviar al super admin
        Mail::to('danielosco88@gmail.com')->send(new NuevoEmpleadoAdminMailable($empleado));

        // 📩 Enviar correo de bienvenida al empleado
        if ($empleado->email) {
            Mail::to($empleado->email)->send(new BienvenidaEmpleadoMailable($empleado));
        }
    }
}
