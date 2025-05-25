<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookable\TimeSlotStoreRequest;
use App\Http\Requests\Bookable\TimeSlotUpdateRequest;
use App\Models\Bookable;
use App\Models\TimeSlots;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimeSlotsController extends Controller
{
    public function index(){
        return Inertia::render("Bookable/TimeSlots/Index", [
            'timeSlots' => TimeSlots::where('bookable_id', Auth::user()->bookable->id)->get(),
            'user' => Auth::user(),
            'bookables'=>Bookable::with(['timeSlots','user','type'])->get(),
        ]);
    }
    public function create()
    {
        $user = Auth::user();
        $bookable=$user->bookable;
        return Inertia::render(
            'Bookable/TimeSlots/Create',
            [
                'user' =>$user,
                'bookable'=>$bookable
            ]
        );
    }

    public function store(TimeSlotStoreRequest $request)
    {
        $validatedData = $request->validated();
        TimeSlots::create($validatedData);
        return redirect()->back();
    }

    public function update(TimeSlotUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $timeSlot = TimeSlots::find($id);
        if (! $timeSlot) {
            return redirect()->back()->withErrors(['message' => 'Time slot not found'])->setStatusCode(404);
        }

        $timeSlot->update($validatedData);

        return redirect()->back();

    }

    public function destroy($id)
    {
        // Delete a time slot
        $timeSlot = TimeSlots::find($id);
        if (! $timeSlot) {
            return redirect()->back()->withErrors(['message' => 'Time slot not found'])->setStatusCode(404);
        }

        $timeSlot->delete();
        return redirect()->back();

    }
}
