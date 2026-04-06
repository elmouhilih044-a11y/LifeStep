<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeProfile extends Model
{
    protected $fillable = [
        'profile_type',
        'budget_min',
        'budget_max',
        'location',
        'search_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}