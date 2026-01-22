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
    return (new MailMessage)
        ->subject('Nuovo pagamento registrato')
        ->greeting('Ciao ' . $notifiable->name)
        ->line('È stato registrato un nuovo pagamento.')
        ->line('Importo: € ' . number_format($this->payment->amount, 2))
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
