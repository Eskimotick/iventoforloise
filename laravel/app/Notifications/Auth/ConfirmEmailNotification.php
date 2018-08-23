<?php

namespace App\Notifications\Auth;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmEmailNotification extends Notification
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
        // dd($notifiable);
        return (new MailMessage)
                ->subject('Seja bem-vindo ao '.env('APP_NAME'))
                ->greeting($notifiable->name)
                ->line('A sua inscrição no '.env('APP_NAME'). ' está quase concluída.')
                ->line('Você só tem que verificar seu e-mail clicando no link a seguir:')
                ->action('Confirme seu e-mail', env('App_Url').'/confirm/'.$notifiable->confirmation_code)
                ->line('Qualquer dúvida nossa equipe está sempre a disposição!');
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
