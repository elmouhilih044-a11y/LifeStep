<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = [
    'name'
];

public function logements()
{
    return $this->belongsToMany(Logement::class, 'logement_badge');
}
}
