<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioEmails extends Mailable
{
    use Queueable, SerializesModels;

    private $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $this->subject('Alteração de Senha - Certifica Coop');
        $this->to($this->usuario->email, $this->usuario->nome);
        return $this->markdown('mail.envioEmail', [
            'usuario' => $this->usuario
        ]);
    }

}
