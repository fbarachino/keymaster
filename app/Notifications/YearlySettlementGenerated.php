<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YearlySettlementGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    public $amount;
    public $year;
    public $dueDate;

    public function __construct(float $quota, int $year, $dueDate)
    {
        $this->quota = $quota;
        $this->year = $year;
        $this->dueDate = $dueDate;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Conguaglio spese {$this->year}")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È stato generato il conguaglio annuale delle spese.")
            ->line("**La tua quota:** € " . number_format($this->quota, 2, ',', '.'))
            ->line("**Scadenza:** " . $this->dueDate->format('d/m/Y'))
            ->action('Visualizza i pagamenti', url('/tenant/payments'))
            ->line('Grazie per la collaborazione.');
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
