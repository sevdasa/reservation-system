<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('Rereservation.crerated', function () {
//     return true;
// });

// Broadcast::channel('Rereservation.crerated.bookable.{id}', function ($user, $id) {
//     return true;
// });
Broadcast::channel('Reservation.bookable.{id}', function ($user, $id) {
    return true;
});
