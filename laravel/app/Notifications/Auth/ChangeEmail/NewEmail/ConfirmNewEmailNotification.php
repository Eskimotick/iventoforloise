<?php

namespace App\Notifications\Auth\ChangeEmail\NewEmail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmNewEmailNotification extends Notification
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
      ->subject('Alteração de e-mail do '.env('APP_NAME').'.')
      ->line('Recebemos sua solicitação para trocar de e-mail.')
      ->line('Por favor confirme seu e-mail novo clicando no botão abaixo.')
      ->action('Confirmar e-mail', env('App_Url').'/confirm/'.$notifiable->new_email_code)
      ->line('Caso não tenha solicitado a alteação desconsidere esta mensagem.')
      ->line('Seu e-mail só será alterado assim que a confirmação for realizada tanto neste quanto no e-mail antigo.')
      ->line('A operação será cancelada caso a confirmação não ocorra em 24 horas.')
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
