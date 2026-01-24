<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'floor',
        'size',
        'monthly_rent',
        'status',
    ];

    /* RELAZIONI */

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function lease()
    {
        return $this->hasOne(Lease::class);
    }

    public function leases() { return $this->hasMany(\App\Models\Lease::class); }

    public function photos()
    {
        return $this->hasMany(UnitPhoto::class);
    }

    public function inventory()
    {
        return $this->hasMany(UnitInventory::class);
    }

    public function documents()
    {
        return $this->hasMany(UnitDocument::class);
    }

    public function activeLease()
    {
        return $this->leases()
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                ->orWhere('end_date', '>=', now());
            })
            ->first();
    }


}
