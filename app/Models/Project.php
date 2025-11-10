<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'budget',
        'deadline',
        'user_id', // the client or customer posting the project
        'customer_id', // optional if project created by a Customer model
    ];

    // A project belongs to one user (freelancer or client)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A project belongs to one customer (if applicable)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // A project can have many proposals
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    // A project can have many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
