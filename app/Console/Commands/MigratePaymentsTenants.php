<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Console\Command;

class MigratePaymentsTenants extends Command
{
    protected $signature = 'payments:migrate-tenants';
    protected $description = 'Assegna i tenant corretti ai pagamenti esistenti (Modello C)';

    public function handle(): int
    {
        $leases = Lease::with('tenants')->get();

        foreach ($leases as $lease) {
            $tenant = $lease->tenants->first();

            if (!$tenant) {
                $this->warn("Lease {$lease->id} non ha tenants, salto.");
                continue;
            }

            Payment::where('lease_id', $lease->id)
                ->whereNull('tenant_id')
                ->update(['tenant_id' => $tenant->id]);

            $this->info("Pagamenti lease {$lease->id} aggiornati → tenant {$tenant->id}");
        }

        $this->info("Migrazione completata.");
        return self::SUCCESS;
    }
}
