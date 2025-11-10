<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'cover_letter',
        'bid_amount',
        'status', // pending, accepted, rejected
    ];

    // A proposal belongs to a user (freelancer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A proposal belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
