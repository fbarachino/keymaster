<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lease;
use App\Models\Tenant;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Creiamo tenants dai vecchi users collegati alle lease
        $leases = Lease::with('user')->get();

        foreach ($leases as $lease) {
            if (!$lease->user) {
                continue;
            }

            // Crea tenant se non esiste già
            $tenant = Tenant::firstOrCreate(
                ['user_id' => $lease->user->id],
                [
                    'name' => $lease->user->name,
                    'email' => $lease->user->email,
                    'phone' => $lease->user->phone ?? null,
                ]
            );

            // 2) Collega tenant alla lease
            $lease->tenants()->syncWithoutDetaching([$tenant->id]);
        }
    }

    public function down(): void
    {
        // Non cancelliamo nulla per sicurezza
    }
};
