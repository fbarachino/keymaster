<?php

namespace App\Notifications;

use App\Models\Lease;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MonthlyLeaseSummaryGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lease;
    protected $pdfContent;
    protected $period;

    public function __construct(Lease $lease, string $pdfContent, string $period)
    {
        $this->lease = $lease;
        $this->pdfContent = $pdfContent;
        $this->period = $period;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Riepilogo mensile lease – {$this->period}")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È stato generato il riepilogo mensile della lease per il periodo **{$this->period}**.")
            ->line("Il documento contiene:")
            ->line("- Totale affitto del mese")
            ->line("- Totale anticipo spese")
            ->line("- Totale complessivo della lease")
            ->line("- Elenco tenants attivi")
            ->attachData(
                $this->pdfContent,
                "riepilogo_lease_{$this->lease->id}_{$this->period}.pdf",
                ['mime' => 'application/pdf']
            )
            ->action('Apri la tua area riservata', url('/landlord/leases/' . $this->lease->id))
            ->line('Grazie per utilizzare KeyMaster.');
    }
}
