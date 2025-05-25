<?php

namespace App\Enum;

use App\Interfaces\HasName;

enum UserRole: string implements HasName
{
    case Bookable = 'bookable';
    case Admin = 'admin';
    case User = 'user';

    public function name(): string
    {
        return match ($this) {
            static::Bookable => 'Bookable',
            static::User => 'User',
            static::Admin => 'Admin',
        };
    }

}
