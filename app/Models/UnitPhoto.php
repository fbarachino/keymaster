<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitPhoto extends Model
{
    protected $fillable = ['unit_id', 'path'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}

