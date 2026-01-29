<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NumberToWords\NumberToWords;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'notes',
        'signed_by_tenant_at',
        'signed_by_landlord_at',
        'signature_token',
        'advance_expenses',
        'split_mode',
    ];

    protected $casts = [ 'start_date' => 'date', 'end_date' => 'date', 'signed_by_tenant_at' => 'datetime', 'signed_by_landlord_at' => 'datetime', ];



    public function isSplitModeEqual()
    {
        return $this->split_mode === 'equal';
    }

    public function property() { return $this->belongsTo(Property::class); }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function tenants()
    {
        return $this->belongsToMany(User::class, 'lease_tenant', 'lease_id', 'tenant_id');
    }

    //public function expenses() { return $this->hasMany(\App\Models\Expense::class); }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments() {
         return $this->hasMany(Payment::class);
    }

    public function yearlyReports()
    {
        return $this->hasMany(YearlyReport::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function currentBalance()
    {
        $totalExpenses = $this->expenses()->sum('tenant_share');

        $totalPayments = $this->payments()
            ->where('status', 'paid')
            ->whereNotIn('type', ['deposit','rent'])
            ->sum('amount');

        return $totalExpenses - $totalPayments;
    }

    public function balanceDetails()
    {
        $totalExpenses = $this->expenses()->sum('tenant_share');

        $totalPayments = $this->payments()
            ->where('status', 'paid')
            ->whereNotIn('type', ['deposit','rent'])
            ->sum('amount');

        return [
            'total_expenses' => $totalExpenses,
            'total_payments' => $totalPayments,
            'balance' => $totalExpenses - $totalPayments,
        ];
    }

    public static function convertNumberToWords($number, $locale = 'it')
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer($locale);
        return $numberTransformer->toWords($number);
    }

}
