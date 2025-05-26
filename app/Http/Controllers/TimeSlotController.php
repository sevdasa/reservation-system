<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookable\TimeSlottoreRequest;
use App\Http\Requests\Bookable\TimeSlotUpdateRequest;
use App\Models\Bookable;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimeSlotController extends Controller
{
    public function index()
    {
        if (Auth::guard('bookable')->check()) {
            $TimeSlot = Auth::guard('bookable')->user()->bookable->TimeSlots()->with('reservation.user')->get();
        } else {
            $TimeSlot = TimeSlot::with('reservation.user')->get();
        }

        return Inertia::render('Bookable/TimeSlots/Index', [
            'TimeSlot' => $TimeSlot,
            'user' => Auth::user(),
            'bookables' => Bookable::with(relations: ['TimeSlots', 'userBookable', 'type'])->get(),
        ]);
    }

    public function create()
    {
        $user = Auth::guard('bookable')->user();
        $bookable = $user->bookable;

        return Inertia::render(
            'Bookable/TimeSlot/Create',
            [
                'user' => $user,
                'bookable' => $bookable,
            ]
        );
    }

    public function store(TimeSlottoreRequest $request)
    {
        $validatedData = $request->validated();
        TimeSlot::create($validatedData);

        return redirect()->back();
    }

    public function update(TimeSlotUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $timeSlot = TimeSlot::find($id);
        if (! $timeSlot) {
            return redirect()->back()->withErrors(['message' => 'Time slot not found'])->setStatusCode(404);
        }

        $timeSlot->update($validatedData);

        return redirect()->back();

    }

    public function destroy($id)
    {
        // Delete a time slot
        $timeSlot = TimeSlot::find($id);
        if (! $timeSlot) {
            return redirect()->back()->withErrors(['message' => 'Time slot not found'])->setStatusCode(404);
        }

        $timeSlot->delete();

        return redirect()->back();

    }
}
