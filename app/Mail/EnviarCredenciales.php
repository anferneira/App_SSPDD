<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCredenciales extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $nombre;

    public function __construct($nombre, $email ,$password)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Tus credenciales de acceso')
                    ->view('admin.email.credenciales')
                    ->with([
                        'nombre' => $this->nombre,
                        'usuario' => $this->email,
                        'password' => $this->password,
                    ]);
    }
}
