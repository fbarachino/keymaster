<?php

namespace App\Notifications;

use App\Models\Lease;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YearlySettlementGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lease;
    protected $pdfContent;
    protected $year;

    public function __construct(Lease $lease, string $pdfContent, string $year)
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
            ->subject("Conguaglio annuale – {$this->year}")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È stato generato il conguaglio annuale della lease per l'anno **{$this->year}**.")
            ->attachData(
                $this->pdfContent,
                "conguaglio_lease_{$this->lease->id}_{$this->year}.pdf",
                ['mime' => 'application/pdf']
            )
            ->action('Apri la tua area riservata', url('/landlord/leases/' . $this->lease->id))
            ->line('Grazie per utilizzare KeyMaster.');
    }
}
