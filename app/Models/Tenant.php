<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    //
    public function payments() { return $this->hasMany(Payment::class); }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
