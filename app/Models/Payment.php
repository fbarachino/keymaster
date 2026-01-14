<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_id',
        'due_date',
        'paid_date',
        'amount',
        'status',
        'reference',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /* RELAZIONI */

    public function lease() { return $this->belongsTo(Lease::class); }
}
