<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

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
    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
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
}
