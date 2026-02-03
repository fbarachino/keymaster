<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'lease_id',
        'tenant_id',
        'due_date',
        'paid_date',
        'amount_total',
        'amount_paid',
        'status',
        'description',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function isLate()
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }
}
