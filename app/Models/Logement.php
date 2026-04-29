<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Logement extends Model
{
    protected $fillable = [
        'title',
        'type',
        'price',
        'address',
        'city',
        'bathrooms',
        'bedrooms',
        'surface',
        'floor',
        'status',
        'description',
        'phone',
        'user_id',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function compatibilities()
    {
        return $this->hasMany(Compatibility::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
