<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitInventory extends Model
{
    protected $fillable = ['unit_id', 'item', 'condition', 'notes'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
