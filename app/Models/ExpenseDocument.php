<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseDocument extends Model
{
    protected $fillable = [
        'expense_id',
        'file_path',
        'file_name',
        'mime_type',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
