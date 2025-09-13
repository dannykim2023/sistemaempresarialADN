<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $loginUrl;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->loginUrl = url('/admin'); // Ajusta si tu panel está en otra ruta
    }

    public function build()
    {
        return $this->subject('Bienvenido Administrador')
            ->view('emails.admin-welcome');
    }
}
