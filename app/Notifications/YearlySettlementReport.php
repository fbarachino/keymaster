<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class YearlySettlementReport extends Notification
{
    use Queueable;
    public $lease;
    public $pdfContent;
    public $year;

    /**
     * Create a new notification instance.
     */
    public function __construct(Lease $lease, string $pdfContent, int $year)
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
        $total = $this->lease->totals()
            ->where('period', $this->year)
            ->where('period_type', 'yearly')
            ->first();

        return (new MailMessage)
            ->subject("Conguaglio annuale {$this->year}")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È disponibile il conguaglio annuale delle spese per l'anno {$this->year}.")
            ->line("**Totale spese inquilino:** € " . number_format($total->expenses_total, 2, ',', '.'))
            ->line("**Saldo finale della lease:** € " . number_format($total->settlement_total, 2, ',', '.'))
            ->line("Troverai il dettaglio completo nel PDF allegato.")
            ->attachData($this->pdfContent, "conguaglio_{$this->year}.pdf")
            ->action('Accedi alla tua area', url('/tenant/reports'))
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
