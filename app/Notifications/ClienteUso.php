<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClienteUso extends Notification
{
    use Queueable;
    private string $user_name;
    private string $role_name;
    private string $observacion;
    private string $email_admin;
    private int $number_admin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $user_name,string $role_name, string $observacion, string $email_admin, int $number_admin)
    {
        //
        $this->user_name = $user_name;
        $this->role_name = $role_name;
        $this->observacion = $observacion;
        $this->email_admin = $email_admin;
        $this->number_admin = $number_admin;
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
        ->line("Estimado usuario $this->user_name")
        ->line("Le notificamos por medio de la Escuela de Biodanza SRT Puembo que usted se encuentra desactivado de su cuenta")
        ->line("Detalles de la notificacion:")
        ->line("User role: $this->role_name")
        ->line("Observacion: $this->observacion")
        ->line("Si usted desea habilitar nuevamente su cuenta. Le pedimos que se contacte con:")
        ->line("Email de Administrador: $this->email_admin")
        ->line("Contacto: $this->number_admin");
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
