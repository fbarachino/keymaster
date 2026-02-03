<?php

namespace App\Services;

use App\Models\Lease;
use App\Models\Tenant;

class LeaseService
{
    public function calculateQuota(Lease $lease, Tenant $tenant)
    {
        $total = $lease->rent_total;
        $tenants = $lease->tenants;

        switch ($lease->split_mode) {

            case 'equal':
                return round($total / $tenants->count(), 2);

            case 'percentage':
                $percentage = $tenant->pivot->percentage ?? 0;
                return round($total * ($percentage / 100), 2);

            case 'fixed':
                return round($tenant->pivot->fixed_amount ?? 0, 2);

            case 'unit_based':
                // esempio semplice: ogni unit ha un peso uguale
                $unitsCount = $lease->units->count();
                return round($total / $unitsCount, 2);

            case 'custom':
                // qui puoi implementare logiche personalizzate
                // es: return $this->calculateCustom($lease, $tenant);
                // Per ora ritorniamo una quota uguale
                return round($total / $tenants->count(), 2);

            default:
                throw new \Exception("Split mode non riconosciuto: {$lease->split_mode}");
        }
    }
}
