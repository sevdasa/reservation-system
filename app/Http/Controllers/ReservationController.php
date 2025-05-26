<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreRequest;
use App\Models\Bookable;
use App\Models\Reservation;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function confirm(Request $request)
    {
        $bookable = Bookable::findOrFail($request->bookable);
        $slot = TimeSlot::findOrFail($request->slot);

        return Inertia::render('Reservations/Confirm', [
            'bookable' => $bookable,
            'slot' => $slot,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $slot = TimeSlot::findOrFail($request->time_slot_id);
        $bookable = Bookable::findOrFail($request->bookable_id);

        if ($slot->bookable_id !== $bookable->id) {
            return redirect()->route('reservation.index');
        }
        if ($slot->isReserved()) {
            return redirect()->route('reservation.index');
        }

        $slot->update(['is_booked' => true]);
        Reservation::create([
            'time_slot_id' => $slot->id,
            'user_id' => Auth::guard('web')->id(),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => $request->notes ?? '',
        ]);

        return redirect()->route('reservation.index')->with('success', 'رزرو با موفقیت انجام شد!');
    }

    public function index(Request $request)
    {
        $reservations = Reservation::where('user_id', Auth::guard('web')->id())
            ->with(['timeSlot', 'timeSlot.bookable'])
            ->get();

        return Inertia::render('Reservations/Index', [
            'reservations' => $reservations,
        ]);
    }
}
