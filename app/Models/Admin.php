<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory, HasRoles ,Notifiable,SoftDeletes;

    protected $table = 'admins';

    protected $guard = 'admin';

    /*
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

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
