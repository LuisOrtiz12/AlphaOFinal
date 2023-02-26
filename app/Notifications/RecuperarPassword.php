<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecuperarPassword extends Notification
{
    use Queueable;
    private string $token;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        //
        $this->token=$token;

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
                    ->subject('Alerta Completa')
                    ->line("AlphaO le infomra que:.")
                    ->line("La credencial que necesitara como requisito para recuperar contraseña es.")
                    ->line("The introduction to the notification. $this->token");
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
