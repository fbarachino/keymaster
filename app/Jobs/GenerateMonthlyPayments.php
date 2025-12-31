<?php

namespace App\Jobs;

use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateMonthlyPayments implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $leases = Lease::where('status', 'active')->get();

        foreach ($leases as $lease) {
            Payment::create([
                'lease_id' => $lease->id,
                'due_date' => now()->startOfMonth()->addMonth(),
                'amount' => $lease->rent_amount,
                'status' => 'pending',
            ]);
        }
    }
}
