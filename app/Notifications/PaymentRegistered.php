<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRegistered extends Notification implements ShouldQueue
{
    use Queueable;
    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail']; // puoi aggiungere database, sms, ecc.
    }



    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Nuovo pagamento: {$this->payment->reference}")
            ->greeting("Ciao {$notifiable->name},")
            ->line("È stato registrato un nuovo pagamento relativo alla tua quota.")
            ->line("**Tipo:** " . ucfirst(str_replace('_', ' ', $this->payment->type)))
            ->line("**Quota dovuta:** € " . number_format($this->payment->amount_due, 2, ',', '.'))
            ->line("**Scadenza:** " . $this->payment->due_date->format('d/m/Y'))
            ->line("**Lease:** " . $this->payment->lease->unit->name)
            ->action('Accedi alla tua area', url('/tenant/payments'))
            ->line('Grazie per la collaborazione.')
            ->attachData( $pdfContent, "riepilogo_mensile_{$period}.pdf", ['mime' => 'application/pdf'] );
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
