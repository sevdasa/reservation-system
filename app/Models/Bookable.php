<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Bookable extends Model
{
    /** @use HasFactory<\Database\Factories\BookableFactory> */
    use HasFactory,HasRoles;
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'type_id',
    ];
    protected $guard_name = 'bookable';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function timeSlots()
    {
        return $this->hasMany(TimeSlots::class,'bookable_id');
    }
}