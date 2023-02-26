<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserStoredNotification extends Notification
{
    use Queueable;
    private string $user_name;
    private string $role_name;
    private string $temp_password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $user_name, string $role_name, string $temp_password)
    {
        //
        $this->user_name = $user_name;
            $this->role_name = $role_name;
            $this->temp_password = $temp_password;
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
        ->subject('Registration completed')
        ->line("Welcome $this->user_name")
        ->line("You are registered in our Prison System.")
        ->line("Registration details:")
        ->line("User role: $this->role_name")
        ->line("Temporary password: $this->temp_password")
        ->line("You can login our system by clicking on the following button")
        ->action("Login", env('APP_FRONTEND_URL') . '/login')
        ->line("Remember: you have to change the temporary password once you login.");
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
