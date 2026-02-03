<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        // Anagrafica
        'name',
        'surname',
        'email',
        'phone',
        'birth_date',
        'birth_place',
        'fiscal_code',

        // Documento
        'document_type',
        'document_number',
        'document_issued_by',
        'document_issued_at',
        'document_expiry_date',

        // Contatti / Residenza
        'address',
        'city',
        'zip',
        'country',

        // Dati contrattuali
        'occupation',
        'notes',

        // Collegamento opzionale allo user
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'document_issued_at' => 'date',
        'document_expiry_date' => 'date',
    ];

    /**
     * Collegamento opzionale all'utente che accede alla piattaforma.
     * Un tenant può avere 0 o 1 user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione molti-a-molti con le lease.
     * La pivot può contenere dati utili per lo split dell'affitto.
     */
    public function leases()
    {
        return $this->belongsToMany(Lease::class)
                    ->withPivot(['percentage', 'fixed_amount'])
                    ->withTimestamps();
    }

    /**
     * Pagamenti individuali del tenant.
     * Ogni pagamento appartiene a un tenant specifico.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Quote di spesa assegnate al tenant (ripartizione delle expense).
     */
    public function expenseShares()
    {
        return $this->hasMany(ExpenseTenant::class);
    }

    /**
     * Accesso diretto alle expense tramite la pivot expense_tenant.
     */
    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_tenant')
                    ->withPivot('amount');
    }

    /**
     * Documenti allegati al tenant (CI, passaporto, contratto firmato, ecc).
     * Relazione polimorfica.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Nome completo del tenant (helper comodo).
     */
    public function getFullNameAttribute()
    {
        return trim($this->name . ' ' . $this->surname);
    }
}
