<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;
    protected $type;

    public function __construct(Payment $payment, string $type)
    {
        $this->payment = $payment;
        $this->type = $type; // 'upcoming' or 'overdue'
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->type === 'upcoming'
            ? "Promemoria pagamento in scadenza"
            : "Pagamento scaduto";

        $line = $this->type === 'upcoming'
            ? "Il tuo pagamento sta per scadere."
            : "Il tuo pagamento risulta scaduto.";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Ciao {$notifiable->name},")
            ->line($line)
            ->line("Tipo: " . ucfirst(str_replace('_', ' ', $this->payment->type)))
            ->line("Importo: € " . number_format($this->payment->amount_due, 2, ',', '.'))
            ->line("Scadenza: " . $this->payment->due_date->format('d/m/Y'))
            ->action('Vai ai tuoi pagamenti', url('/tenant/payments'))
            ->line('Grazie per utilizzare KeyMaster.');
    }
}
