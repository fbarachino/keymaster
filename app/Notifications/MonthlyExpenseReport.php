<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MonthlyExpenseReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($lease, $pdfContent)
{
    $this->lease = $lease;
    $this->pdfContent = $pdfContent;
}

public function via($notifiable)
{
    return ['mail'];
}

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Report Mensile Spese - ' . now()->format('F Y'))
        ->greeting('Ciao ' . $notifiable->name)
        ->line('In allegato trovi il report delle spese del mese.')
        ->attachData($this->pdfContent, 'report_spese_' . now()->format('Y_m') . '.pdf', [
            'mime' => 'application/pdf',
        ]);
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
