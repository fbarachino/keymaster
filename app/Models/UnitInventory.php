<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryItem;

class UnitInventory extends Model
{
    protected $fillable = ['unit_id', 'item', 'condition', 'notes'];

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }


    public function items() {
        return $this->hasMany(InventoryItem::class, 'unit_inventory_id');
    }


}
