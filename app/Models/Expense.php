<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'lease_id',
        'tenant_id',
        'property_id',
        'category',
        'description',
        'amount_total',
        'amount_tenant',
        'expense_date',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
