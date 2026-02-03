<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'unit_id',
        'lease_id',
        'description',
        'amount_total',
        'charge_to', // landlord | tenants | mixed
        'date',
        'notes',
    ];

    protected $casts = [
        'amount_total' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * Property a cui appartiene la spesa.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Unit specifica (se la spesa riguarda una sola unit).
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Lease attiva al momento della spesa (opzionale).
     */
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    /**
     * Quote assegnate ai tenants.
     */
    public function tenantShares()
    {
        return $this->hasMany(ExpenseTenant::class);
    }

    /**
     * Accesso diretto ai tenants tramite pivot.
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'expense_tenant')
                    ->withPivot('amount');
    }
}
