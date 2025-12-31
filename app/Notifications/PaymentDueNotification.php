<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentDueNotification extends Notification
{
    use Queueable;

    public function __construct(public $payment) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Pagamento in scadenza')
            ->line('Hai un pagamento in scadenza il ' . $this->payment->due_date)
            ->action('Visualizza pagamento', url('/tenant/payments/' . $this->payment->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Pagamento in scadenza il ' . $this->payment->due_date,
            'payment_id' => $this->payment->id,
        ];
    }
}
