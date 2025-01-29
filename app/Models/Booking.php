<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

//    add fillable and guarded
 protected $fillable = [];
    protected $guarded = [];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function guests()
        {
            return $this->hasMany(Guest::class);
        }

        public function cottage()
        {
            return $this->belongsTo(Cottage::class);
        }

        public function bookingServicesSum()
        {
            return $this->hasMany(BookingService::class)
                ->selectRaw('booking_id, sum(price) as total_price')
                ->groupBy('booking_id');
        }

        public function bookingPayments()
        {
            return $this->hasMany(BookingPayment::class);
        }

}
