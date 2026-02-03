<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'start_date',
        'end_date',
        'rent_total',
        'deposit',
        'split_mode', // equal | percentage | fixed | unit_based | custom
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rent_total' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenants() { return $this->belongsToMany(Tenant::class) ->withPivot(['percentage', 'fixed_amount']) ->withTimestamps(); }

    public function units() { return $this->belongsToMany(Unit::class, 'lease_unit') ->withPivot('weight') ->withTimestamps(); }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
