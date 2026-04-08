<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
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
