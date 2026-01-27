<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'unit_inventory_id',
        'name',
        'quantity',
        'condition',
        'notes',
    ];

    public function inventory()
    {
        return $this->belongsTo(UnitInventory::class, 'unit_inventory_id');
    }
}
