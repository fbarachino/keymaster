<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $fillable = [
        'lease_id',
        'tenant_id',
        'type',
        'amount',        // totale lease (se usi ancora questo campo)
        'amount_due',    // quota individuale
        'amount_paid',
        'due_date',
        'paid_at',
        'status',
        'reference',
        'notes',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
