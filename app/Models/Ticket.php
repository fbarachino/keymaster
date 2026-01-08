<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'tenant_id',
        'landlord_id',
        'unit_id',
        'title',
        'description',
        'status',
        'priority',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function notes()
    {
        return $this->hasMany(TicketNote::class);
    }
}
