<?php

namespace App\Models;

use App\Models\Landlord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',

        // Dati economici
        'purchase_price',

        // Indirizzo
        'address',
        'zip',
        'city',
        'province',
        'country',

        // Dati catastali
        'cadastral_sheet',
        'cadastral_particle',
        'cadastral_sub',
        'cadastral_category',
        'cadastral_class',
        'cadastral_rent',

        // Note interne
        'notes',
    ];

    /**
     * Landlords (comproprietari) della property.
     * Relazione molti-a-molti tramite property_landlord.
     */
    public function landlords()
    {
        return $this->belongsToMany(Landlord::class, 'property_landlord')
                    ->withPivot('ownership_percentage')
                    ->withTimestamps();
    }

    /**
     * Unità immobiliari appartenenti alla property.
     */
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Lease associate alla property.
     */
    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    /**
     * Spese associate alla property.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Tenants che vivono in questa property (tramite lease).
     */
    public function tenants()
    {
        return $this->hasManyThrough(Tenant::class, Lease::class);
    }

    /**
     * Pagamenti relativi a questa property (tramite lease).
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Lease::class);
    }
}
