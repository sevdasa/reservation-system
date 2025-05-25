<?php

namespace App\Enum;

use App\Interfaces\HasName;

enum UserPermission: string implements HasName
{

    // // Bookable Permissions
    // case BookableTypeIndex = 'bookable.type.index';
    // case BookableTypeShow = 'bookable.type.show';
    // case BookableTypeCreate = 'bookable.type.create';
    // case BookableTypeEdit = 'bookable.type.edit';
    // case BookableTypeDelete = 'bookable.type.delete';

    // case BookableIndex = 'bookable.index';
    // case BookableShow = 'bookable.show';
    // case BookableCreate = 'bookable.create';
    // case BookableEdit = 'bookable.edit';
    // case BookableDelete = 'bookable.delete';

    case ReservationIndex = 'reservation.index';
    case ReservationShow = 'reservation.show';
    case ReservationCreate = 'reservation.create';
    case ReservationEdit = 'reservation.edit';
    case ReservationDelete = 'reservation.delete';

    // Roles Permissions
    case RolesIndex = 'roles.index';
    case RolesShow = 'roles.show';
    case RolesCreate = 'roles.create';
    case RolesEdit = 'roles.edit';
    case RolesDelete = 'roles.delete';

    // Bookable Permissions
    case BookableIndex = 'bookable.index';
    case BookableShow = 'bookable.show';
    case BookableCreate = 'bookable.create';
    case BookableEdit = 'bookable.edit';
    case BookableDelete = 'bookable.delete';

    // User Permissions
    case UserIndex = 'user.index';
    case UserShow = 'user.show';
    case UserCreate = 'user.create';
    case UserEdit = 'user.edit';
    case UserDelete = 'user.delete';

    /**
     * Get user permission name
     */
    public function name(): string
    {
        return match ($this) {
            // self::BookableTypeIndex => 'Bookable Type Index',
            // self::BookableTypeShow => 'Bookable Type Show',
            // self::BookableTypeCreate => 'Bookable Type Create',
            // self::BookableTypeEdit => 'Bookable Type Edit',
            // self::BookableTypeDelete => 'Bookable Type Delete',
            self::BookableCreate => 'Bookable Create',
            self::BookableIndex => 'Bookable Index',
            self::BookableShow => 'Bookable Show',
            self::BookableEdit => 'Bookable Edit',
            self::BookableDelete => 'Bookable Delete',

            self::ReservationIndex => 'Reservation Index',
            self::ReservationShow => 'Reservation Show',
            self::ReservationCreate => 'Reservation Create',
            self::ReservationEdit => 'Reservation Edit',
            self::ReservationDelete => 'Reservation Delete',

            self::RolesIndex => 'Roles Index',
            self::RolesShow => 'Roles Show',
            self::RolesCreate => 'Roles Create',
            self::RolesEdit => 'Roles Edit',
            self::RolesDelete => 'Roles Delete',

    

            self::UserIndex => 'User Index',
            self::UserShow => 'User Show',
            self::UserCreate => 'User Create',
            self::UserEdit => 'User Edit',
            self::UserDelete => 'User Delete',
        };
    }

    /**
     * Get the corresponding guard for the permission.
     */
    public function guard(): string
    {
        return match ($this) {
            // self::BookableTypeIndex, self::BookableTypeShow, self::BookableTypeCreate,
            // self::BookableTypeEdit, self::BookableTypeDelete, self::BookableDelete,
            self::BookableCreate,
            self::BookableEdit, self::BookableDelete, self::BookableIndex,
            self::BookableShow, self::UserIndex,
            self::UserCreate, self::UserDelete => 'bookable',
            self::UserShow,  self::ReservationIndex, self::ReservationShow,
            self::ReservationCreate, self::ReservationEdit, self::ReservationDelete,
            self::UserEdit => 'user',
            self::RolesIndex, self::RolesShow, self::RolesCreate, self::RolesEdit,
            self::RolesDelete, self::BookableCreate,self::BookableEdit => 'admin',
            default => 'web',
        };
    }
}

