<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class ReservationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    // public function broadcastOn(): array
    // {
    //     return [
    //         // new Channel('Reservation.bookable.' . $this->reservation->timeSlot->bookable_id),
    //            new PrivateChannel('Reservation.bookable.' . $this->reservation->timeSlot->bookable_id)

    //     ];
    // }
    public function broadcastOn()
    {
        return new PrivateChannel('Reservation.bookable.'.$this->reservation->timeSlot->bookable_id);
    }
}
