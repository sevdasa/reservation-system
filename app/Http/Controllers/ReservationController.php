<?php

namespace App\Http\Controllers;

use App\Events\ReservationCreated;
use App\Http\Requests\Reservation\StoreRequest;
use App\Models\Bookable;
use App\Models\Reservation;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
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
        $reservation= Reservation::where('time_slot_id', $slot->id)
            ->where('user_id', 2)
            ->first();
            // dd($reservation);
        // dd($request->all(),Auth::guard('web')->user()->id);
        // $slot->update(['is_booked' => true]);
        // $reservation = Reservation::create([
        //     'time_slot_id' => $slot->id,
        //     'user_id' => Auth::guard('web')->user()->id ?? 2,
        //     'status' => 'pending',
        //     'payment_status' => 'unpaid',
        //     'notes' => $request->notes ?? '',
        //     'bookable_id' => $bookable->id,
        // ]);

        // Redis::publish('reservation-channel', json_encode([
        //     'message' => 'رزرو جدید ثبت شد!',
        //     // 'user' => $bookable->userBookable->name,
        //     'user'=> Auth::guard('web')->user()->name,
        // ]));
        broadcast(new ReservationCreated($reservation));

        return redirect()->route('reservation.index', ['id' => $bookable->id])->with('success', 'رزرو با موفقیت انجام شد!');
    }

    public function index(Request $request, $id = null)
    {

        $reservations = Reservation::where('user_id', 2)
            ->with(['timeSlot', 'timeSlot.bookable'])
            ->get();

        return Inertia::render('Reservations/Index', [
            'reservations' => $reservations,
            'bookable_id' => $id,
        ]);
    }
}
