<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class YearlySettlementReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($lease, $pdfContent, $year)
{
    $this->lease = $lease;
    $this->pdfContent = $pdfContent;
    $this->year = $year;
}

public function via($notifiable)
{
    return ['mail'];
}

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject("Conguaglio Spese - Anno {$this->year}")
        ->greeting("Ciao {$notifiable->name}")
        ->line("In allegato trovi il conguaglio annuale delle spese.")
        ->attachData(
            $this->pdfContent,
            "conguaglio_{$this->year}_lease_{$this->lease->id}.pdf",
            ['mime' => 'application/pdf']
        );
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
