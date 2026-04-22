<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
      protected $fillable = [
        'reservation_id',
        'amount',
        'due_date',
        'status',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
