<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearlyReport extends Model
{
    protected $fillable = [
        'lease_id',
        'year',
        'file_path',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
