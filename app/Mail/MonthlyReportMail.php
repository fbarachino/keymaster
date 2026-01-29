<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $lease;
    public $tenant;

    public function __construct($report, $lease, $tenant, $documents = [])
    {
        $this->report = $report;
        $this->lease = $lease;
        $this->tenant = $tenant;

        // Allego i documenti
        foreach ($documents as $doc) {
            $this->attach(storage_path('app/' . $doc->file_path), [
                'as' => $doc->file_name,
                'mime' => $doc->mime_type,
            ]);
        }
    }

    public function build()
    {
        //dd($this->lease->advance_expenses);
        //dd($this->report);
        return $this
            ->subject('Report mensile – ' . $this->lease->unit->property->name)
            ->markdown('emails.reports.monthly');
    }
}
