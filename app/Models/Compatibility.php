<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    protected $fillable = [
    'logement_id',
    'life_profile_id',
    'score'
];

public function logement() {
    return $this->belongsTo(Logement::class);
}

public function lifeProfile() {
    return $this->belongsTo(LifeProfile::class);
}
}
