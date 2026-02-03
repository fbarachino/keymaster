<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // app/Models/User.php

protected $fillable = [ 'name', 'email', 'password', 'language', 'notification_preference', 'telegram_chat_id',
// dati personali
'first_name', 'last_name', 'birth_date', 'birth_place', 'fiscal_code', 'nationality',
// residenza
'address', 'zip', 'city', 'province', 'country', 'role',
// documento
'document_type', 'document_number', 'document_issue_date', 'document_expiry_date', 'document_issuer',
// contatti
'phone', ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* RELAZIONI */

    // Proprietà possedute (solo se landlord)
    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    // Contratti come inquilino
 /*   public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
    }*/
    public function leases()
{
    return $this->belongsToMany(Lease::class, 'lease_tenant', 'tenant_id', 'lease_id');
}


    // Messaggi inviati
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messaggi ricevuti
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Notifiche
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function landlord() { return $this->hasOne(Landlord::class); }
}
