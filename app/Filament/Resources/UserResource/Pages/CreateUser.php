<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User; // <-- importar User
use Illuminate\Support\Facades\Mail; // <-- importar Mail
use App\Mail\AdminWelcomeMail; // <-- importar tu mailable
use Filament\Resources\Pages\CreateRecord;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): User
        {
            $plainPassword = $data['password']; // en texto plano desde el form

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($plainPassword), // encriptada en BD
            ]);

            $user->assignRole('admin');

            // Enviar el password plano por correo
            Mail::to($user->email)->send(new AdminWelcomeMail($user->email, $plainPassword));

            return $user;
        }

}
