<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;


    protected $fillable = [
           'name',
        'landlord_id',
        'address',
        'description',
    'purchase_price',

    'address', 'zip', 'city', 'province', 'country',

    'cadastral_sheet', 'cadastral_particle', 'cadastral_sub',
    'cadastral_category', 'cadastral_class', 'cadastral_rent',
];


    /* RELAZIONI */

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    // app/Models/Property.php

    public function grossYield()
    {
        if (!$this->purchase_price || $this->purchase_price <= 0) {
            return null;
        }

        // Somma affitti annui di tutte le unità con lease attiva
        $annualRent = $this->units->sum(function ($unit) {
            $lease = $unit->activeLease();
            return $lease ? ($lease->rent_amount * 12) : 0;
        });

        return ($annualRent / $this->purchase_price) * 100;
    }

    /* public function netYield()
    {
        if (!$this->purchase_price || $this->purchase_price <= 0) {
            return null;
        }

        // Affitto annuo
        $annualRent = $this->units->sum(function ($unit) {
            $lease = $unit->activeLease();
            return $lease ? ($lease->rent_amount * 12) : 0;
        });

        // Costi annui (se vuoi puoi aggiungere un campo dedicato)
        $annualCosts = $this->annual_costs ?? 0;

        return (($annualRent - $annualCosts) / $this->purchase_price) * 100;
    } */


/*         public function netYield()
{
    if (!$this->purchase_price || $this->purchase_price <= 0) {
        return null;
    }

    // Affitto annuo
    $annualRent = $this->units->sum(function ($unit) {
        $lease = $unit->activeLease();
        return $lease ? ($lease->rent_amount * 12) : 0;
    });

    // Costi annui del landlord
    $annualCosts = $this->annualLandlordCosts();

    return (($annualRent - $annualCosts) / $this->purchase_price) * 100;
} */


    public function netYield()
{
    if (!$this->purchase_price || $this->purchase_price <= 0) {
        return null;
    }

    // Affitto annuo
    $annualRent = $this->units->sum(function ($unit) {
        $lease = $unit->activeLease();
        return $lease ? ($lease->rent_amount * 12) : 0;
    });

    // Costi annuali del landlord
    $annualCosts = $this->annualLandlordCosts();

    return (($annualRent - $annualCosts) / $this->purchase_price) * 100;
}

    public function annualLandlordCosts() {
        return $this->units->sum(function ($unit) {
            $lease = $unit->activeLease();
            if (!$lease) { return 0; }
            return $lease->expenses()
                ->where('charged_to', 'landlord')
                ->whereYear('date', now()->year)
                ->sum('amount');
            }); }

}
