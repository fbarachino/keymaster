<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Unit extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'type',
        'floor',
        'size_sqm',
        'interior',
        'rooms',
        'accessory',
        'status',
        'monthly_rent',
        'notes',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function leases()
    {
        return $this->belongsToMany(Lease::class, 'lease_unit')
                    ->withPivot('weight')
                    ->withTimestamps();
    }
}
