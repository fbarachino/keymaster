<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitDocument extends Model
{
    protected $fillable = ['unit_id', 'name', 'path'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
