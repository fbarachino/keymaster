<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'tenant_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /* RELAZIONI */

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
