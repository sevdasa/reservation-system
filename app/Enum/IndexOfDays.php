<?php

namespace App\Enum;

enum IndexOfDays: int
{
    case Sunday = 0;
    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;

    /**
    * Get user role name
    */
    public function name(): string
    {
        return match ($this) {
            self::Saturday => 'شنبه',
            self::Sunday => 'یکشنبه',
            self::Monday => 'دوشنبه',
            self::Tuesday => 'سه‌شنبه',
            self::Wednesday => 'چهارشنبه',
            self::Thursday => 'پنج‌شنبه',
            self::Friday => 'جمعه',
        };
    }
    public static function toArray(): array
    {
        return [
            self::Saturday->value => self::Saturday->name(),
            self::Sunday->value => self::Sunday->name(),
            self::Monday->value => self::Monday->name(),
            self::Tuesday->value => self::Tuesday->name(),
            self::Wednesday->value => self::Wednesday->name(),
            self::Thursday->value => self::Thursday->name(),
            self::Friday->value => self::Friday->name(),
        ];
    }
}
