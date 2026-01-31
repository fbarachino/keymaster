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

    public function __construct($payment)
{
    $this->payment = $payment;
}

public function via($notifiable)
{
    return ['mail']; // puoi aggiungere database, sms, ecc.
}

public function toMail($notifiable)
{

        if($this->payment->lease->where('split_mode', 'equal')->exists())
        {
            $paymentQuotas = $this->payment->amount / $this->payment->lease->tenants->count();
            $lineAmount = 'Importo per te da versare: € ' . number_format($paymentQuotas, 2);
        }
        else {
            $lineAmount = 'Importo da versare: € ' . number_format($this->payment->amount, 2);
        }

    return (new MailMessage)
        ->subject('Nuovo pagamento registrato')
        ->greeting('Ciao ' . $notifiable->name)
        ->line('È stato registrato un nuovo pagamento per un totale di € ' . number_format($this->payment->amount, 2) . '.')
        ->line($lineAmount ?? 'Nessun importo da pagare')
        ->line('Data scadenza: ' . $this->payment->due_date)
        ->action('Visualizza pagamento', url('/tenant/payments/' . $this->payment->id));
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
