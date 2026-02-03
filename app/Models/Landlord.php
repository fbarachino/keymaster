<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

 //
   class Landlord extends Model
    {
        use HasFactory;

        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'birth_date',
            'birth_place',
            'fiscal_code',
            'document_type',
            'document_number',
            'document_issued_by',
            'document_issued_at',
            'document_expiry_date',
            'address',
            'city',
            'zip',
            'country',
            'occupation',
            'notes',
            'user_id',
        ];

        // Account utente (opzionale)
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        // Lease collegate (molti-a-molti)
        public function leases()
        {
            return $this->belongsToMany(Lease::class)
                        ->withPivot(['percentage', 'fixed_amount'])
                        ->withTimestamps();
        }

        // Pagamenti individuali
        public function payments()
        {
            return $this->hasMany(Payment::class);
        }

        // Quote di spesa
        public function expenseShares()
        {
            return $this->hasMany(ExpenseTenant::class);
        }

        // Accesso diretto alle spese
        public function expenses()
        {
            return $this->belongsToMany(Expense::class, 'expense_tenant')
                        ->withPivot('amount');
        }

        // Documenti allegati (opzionale)
        public function documents()
        {
            return $this->morphMany(Document::class, 'documentable');
        }

        public function properties()
        {
            return $this->belongsToMany(Property::class, 'property_landlord')
                        ->withPivot('ownership_percentage')
                        ->withTimestamps();
        }

    }




