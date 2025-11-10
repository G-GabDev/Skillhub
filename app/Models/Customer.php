<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 Relationships

    // Customer can create multiple projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Messages sent by the customer
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages received by the customer
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
