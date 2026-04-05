<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeProfile extends Model
{
   protected $fillable = [
        'type',
        'budget_min',
        'budget_max',
        'location',
        'user_id'
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }
       public function compatibilities()
    {
        return $this->hasMany(Compatibility::class);
    }
}
