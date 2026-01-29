<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'lease_id',
        'type',
        'amount',
        'charged_to',
        'tenant_share',
        'landlord_share',
        'date',
        'notes',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }



    public function documents()
    {
        return $this->hasMany(ExpenseDocument::class);
    }

}
