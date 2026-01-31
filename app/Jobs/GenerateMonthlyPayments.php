<?php

namespace App\Jobs;

use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use App\Notifications\PaymentRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateMonthlyPayments implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $leases = Lease::where('status', 'active')->get();

        foreach ($leases as $lease) {
            $rent=Payment::create([
                'lease_id' => $lease->id,
                'due_date' => now()->startOfMonth()->addMonth(),
                'amount' => $lease->rent_amount,
                'status' => 'pending',
                'type' => 'rent',
            ]);

            $advance=Payment::create([
                'lease_id' => $lease->id,
                'due_date' => now()->startOfMonth()->addMonths(),
                'amount' => $lease->advance_amount,
                'status' => 'pending',
                'type' => 'advance',
            ]);
            foreach ($lease->tenants as $tenant) {
                $tenant->notify(new PaymentRegistered($rent));
                $tenant->notify(new PaymentRegistered($advance));
            }
        }
    }
}
