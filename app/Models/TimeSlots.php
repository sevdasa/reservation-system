<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlots extends Model
{
    /** @use HasFactory<\Database\Factories\TimeSlotsFactory> */
    use HasFactory;
    protected $fillable = [
        'bookable_id',
        'start_time',
        'end_time',
        'date',
        'is_booked',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date',
    ];              
    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }

    public function isReserved()
    {
        return $this->is_booked;
    }
}
