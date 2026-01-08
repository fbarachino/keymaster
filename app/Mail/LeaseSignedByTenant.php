<?php

namespace App\Mail;

use App\Models\Lease;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaseSignedByTenant extends Mailable
{
    use Queueable, SerializesModels;

    public $lease;

    public function __construct(Lease $lease)
    {
        $this->lease = $lease;
    }

    public function build()
    {
        return $this->subject('Un contratto è stato firmato dal tenant')
            ->view('emails.leases.signed-by-tenant');
    }
}
