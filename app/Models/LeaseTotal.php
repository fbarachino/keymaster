<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseTotal extends Model
{
    protected $fillable = [
        'lease_id',
        'period',
        'period_type',
        'rent_total',
        'expenses_total',
        'advance_total',
        'settlement_total',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
