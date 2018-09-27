<?php

namespace App\Notifications\Atividade;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateAtividadePacoteNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Atividade modificada em seu pacote no '.env('APP_NAME').'.')
        ->greeting($notifiable->name)
        ->line('Uma atividade do seu pacote do '.env('APP_NAME').' foi modificada.')
        ->line('Acesse o '.env('APP_NAME'). ' para conferir as mudanças do seu pacote.')
        ->line('Atenciosamente, equipe '.env('APP_NAME').'.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
