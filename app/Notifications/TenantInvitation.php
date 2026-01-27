<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenantInvitation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Benvenuto su KeyMaster')
            ->line('Il proprietario ti ha aggiunto al sistema.')
            ->line('Per accedere devi impostare la tua password.')
            ->action('Imposta la password', url(route('password.request')))
            ->line('Appena hai impostato la password, potrai accedere al tuo account e gestire le tue locazioni.')
            ->line('Ci raccomandiamo di completare i dati presenti nel tuo profilo per una migliore esperienza.')
            ->line('Grazie per utilizzare il nostro servizio.');
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
