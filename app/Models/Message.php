<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'sender_id',
        'receiver_id',
        'content',
    ];

    // Each message is related to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Sender can be User or Customer
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Receiver can be User or Customer
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
