<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   protected $fillable = [
    'user_id',
    'logement_id',
    'total_price',
    'deposit_amount',
    'payment_method',
    'payment_status',
    'start_date',
    'status',
    'cancelled_at',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function logement()
{
    return $this->belongsTo(Logement::class);
}
public function monthlyPayments()
{
    return $this->hasMany(MonthlyPayment::class);
}
}
