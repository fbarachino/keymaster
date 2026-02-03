<?php

namespace App\Mail;

use App\Models\Lease;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaseExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lease;

    public function __construct(Lease $lease)
    {
        $this->lease = $lease;
    }

    public function build()
    {
        return $this->subject('Contratto in scadenza')
            ->view('emails.lease_expiring');
    }
}
