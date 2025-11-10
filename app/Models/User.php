<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // freelancer or client
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Relationships

    // User can own many projects (if they post as a client)
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // User can send proposals to projects
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    // Messages the user has sent
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages the user has received
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function isClient()
{
    return $this->role === 'client';
}

public function isFreelancer()
{
    return $this->role === 'freelancer';
}

}
