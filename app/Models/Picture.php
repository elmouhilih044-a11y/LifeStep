<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
    'path',
    'order',
    'logement_id'
];

public function logement() {
    return $this->belongsTo(Logement::class);
}
}
