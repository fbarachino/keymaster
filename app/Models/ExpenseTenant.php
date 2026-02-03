<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseTenant extends Model
{
    use HasFactory;

    protected $table = 'expense_tenant';

    protected $fillable = [
        'expense_id',
        'tenant_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * La spesa a cui questa quota appartiene.
     */
    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    /**
     * Il tenant a cui è stata assegnata questa quota.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
