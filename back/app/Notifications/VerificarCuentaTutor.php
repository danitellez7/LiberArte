<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;

class VerificarCuentaTutor extends Notification{

    use Queueable, SerializesModels;

    public $url;
    
    /**
     * Recibe el enlace de verificación
     */
    public function __construct($url){

        $this->url = $url;
    }

    public function via($notifiable){
        return ['mail'];
    }

    /**
     * Construimos el email con la plantilla que hemos generado
     */
    public function toMail($notifiable){

        return (new MailMessage)
            ->subject('Verificar Cuenta Tutor')
            ->view('emails.verificar-cuenta-tutor', [
                'url' => $this->url,
                'usuario'=> $notifiable
            ]);
    }
}
