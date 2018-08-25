<?php

namespace App\Notifications\Auth\ChangeEmail\OldEmail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OldEmailConfirmedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('E-mail antigo confirmado com sucesso.')
        ->line('Sua requisição de troca de e-mail foi verificada com sucesso.')
        ->line('Você poderá usar seu novo e-mail no '.env('APP_NAME').'assim que também efetuar a confirmação através dele.')
        ->line('Clique no botão abaixo para voltar ao site')
        ->action('Ir ao site', env('App_Url').'/login')
        ->line('Qualquer dúvida nossa equipe está sempre à disposição!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
