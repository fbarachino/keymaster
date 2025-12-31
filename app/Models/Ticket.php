<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'tenant_id', 'unit_id', 'title', 'description', 'status'
    ];

    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); }
    public function unit() { return $this->belongsTo(Unit::class); }
}
