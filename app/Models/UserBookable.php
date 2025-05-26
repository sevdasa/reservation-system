<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class UserBookable extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserBookableFactory> */
    use HasFactory,Notifiable;
    use HasRoles;

    protected $guard_name = 'bookable';
    protected $table = 'user_bookables';
        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
        'avatar',
    ];

    public function bookable()  {
        return $this->hasOne(Bookable::class);
    }
}
