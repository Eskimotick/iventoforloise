<?php

namespace App\Notifications\Atividade;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NovaAtividadePacoteNotification extends Notification
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
        ->subject('Nova atividade disponível para seu pacote no '.env('APP_NAME').'.')
        ->greeting($notifiable->name)
        ->line('Uma nova atividade foi adicionada ao seu pacote do '.env('APP_NAME').'.')
        ->line('Confira e corra para garantir sua inscrição!')
        ->line('Atenciosamente, equipe '.env('APP_NAME').'.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
