<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Bookable extends Model
{
    /** @use HasFactory<\Database\Factories\BookableFactory> */
    use HasFactory,HasRoles;

    protected $table = 'bookables';

    protected $fillable = [
        'name',
        'description',
        'user_bookable_id',
        'type_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function userBookable()
    {
        return $this->belongsTo(UserBookable::class, 'user_bookable_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function TimeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'bookable_id');
    }
}
