<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyLandlord extends Model
{
    protected $table = 'property_landlord';

    protected $fillable = [
        'property_id',
        'landlord_id',
        'ownership_percentage',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }
}
