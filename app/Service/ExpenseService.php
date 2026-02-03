<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ExpenseTenant;

class ExpenseService
{
    /**
     * Ripartisce automaticamente la spesa tra i tenants della lease.
     */
    public function distributeExpense(Expense $expense)
    {
        // Se la spesa non è a carico dei tenants, non fare nulla
        if ($expense->charge_to === 'landlord') {
            return;
        }

        // Recupera la lease associata
        $lease = $expense->lease;

        if (!$lease) {
            throw new \Exception("Impossibile ripartire la spesa: nessuna lease associata.");
        }

        $tenants = $lease->tenants;

        if ($tenants->isEmpty()) {
            throw new \Exception("Impossibile ripartire la spesa: nessun tenant nella lease.");
        }

        $quota = $expense->amount_total / $tenants->count();

        foreach ($tenants as $tenant) {
            ExpenseTenant::create([
                'expense_id' => $expense->id,
                'tenant_id' => $tenant->id,
                'amount' => round($quota, 2),
            ]);
        }
    }
}


/* ESEMPIO DI UTILIZZO

$expense = Expense::create([
    'property_id' => $property->id,
    'unit_id' => $unit->id,
    'lease_id' => $lease->id,
    'description' => 'Pulizia scale',
    'amount_total' => 120,
    'charge_to' => 'tenants',
    'date' => now(),
]);

app(\App\Services\ExpenseService::class)->distributeExpense($expense);

*/
