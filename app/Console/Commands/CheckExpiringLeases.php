<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Services\NotificationService;

class CheckExpiringLeases extends Command
{
    protected $signature = 'leases:check-expiring';
    protected $description = 'Genera notifiche per contratti in scadenza';

    public function handle()
    {
        $leases = Lease::where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(60)])
            ->get();

        foreach ($leases as $lease) {

            // Notifica tenant
            foreach ($lease->tenants as $tenant) {
                NotificationService::notify(
                    $tenant->user,
                    'lease_expiring',
                    'Contratto in scadenza',
                    "Il tuo contratto per {$lease->property->name} scade il {$lease->end_date}.",
                    route('tenant.leases.show', $lease->id)
                );
            }

            // Notifica landlord
            foreach ($lease->property->landlords as $landlord) {
                NotificationService::notify(
                    $landlord->user,
                    'lease_expiring',
                    'Contratto in scadenza',
                    "Un contratto per {$lease->property->name} scade il {$lease->end_date}.",
                    route('landlord.leases.edit', [$lease->property_id, $lease->id])
                );
            }
        }

        $this->info('Notifiche contratti in scadenza generate.');
    }
}
