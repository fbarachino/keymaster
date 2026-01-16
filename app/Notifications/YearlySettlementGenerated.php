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

    public function __construct($amount, $year, $dueDate)
    {
        $this->amount = $amount;
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
            ->subject("Conguaglio spese $this->year")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È stato generato il conguaglio delle spese per l'anno $this->year.")
            ->line("Saldo risultante: € " . number_format($this->amount, 2, ',', '.'))
            ->line("Scadenza pagamento: " . $this->dueDate->format('d/m/Y'))
            ->line("Puoi visualizzare i dettagli accedendo alla tua area riservata.")
            ->salutation("Grazie, " . config('app.name'));
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
