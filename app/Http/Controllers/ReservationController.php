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
        $reservation = Reservation::where('time_slot_id', $slot->id)
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
        // if ($id) {
        //    var_dump($id);
        // }
        $query = Reservation::where('user_id', 2)
            ->with(['timeSlot', 'timeSlot.bookable']);
        if ($request->has('bookable_id') && $request->bookable_id) {
            $query->whereHas('timeSlot', function ($q) use ($request) {
                $q->where('bookable_id', $request->bookable_id);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $bookables = Bookable::all(['id', 'name']);

        return Inertia::render('Reservations/Index', [
            'reservations' => $reservations,
            'bookable_id' => $id,
            'bookables' => $bookables,
            'filters' => [
                'bookable_id' => $id,
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
            ],
        ]);
    }
}
