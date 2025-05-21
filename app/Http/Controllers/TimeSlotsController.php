<?php

namespace App\Http\Controllers;

use App\Models\TimeSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimeSlotsController extends Controller
{
    public function create()
    {
        // dd(auth()->user);
        $user = Auth::user();
        return Inertia::render(
            'Doctor/TimeSlots/Create',
            [
                'user' =>$user,
            ]
        );
        // return inertia('Doctor/TimeSlots/Create');
    }

    public function store(Request $request)
    {
        // Validate and create a new time slot
        $validatedData = $request->validate([
            'bookable_id' => 'required|exists:bookables,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'date' => 'required|date',
            'is_booked' => 'boolean',
        ]);

        $timeSlot = TimeSlots::create($validatedData);

        return response()->json($timeSlot, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate and update an existing time slot
        $validatedData = $request->validate([
            'bookable_id' => 'sometimes|required|exists:bookables,id',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i',
            'date' => 'sometimes|required|date',
            'is_booked' => 'sometimes|boolean',
        ]);

        $timeSlot = TimeSlots::find($id);
        if (! $timeSlot) {
            return response()->json(['message' => 'Time slot not found'], 404);
        }

        $timeSlot->update($validatedData);

        return response()->json($timeSlot);
    }

    public function destroy($id)
    {
        // Delete a time slot
        $timeSlot = TimeSlots::find($id);
        if (! $timeSlot) {
            return response()->json(['message' => 'Time slot not found'], 404);
        }

        $timeSlot->delete();

        return response()->json(['message' => 'Time slot deleted successfully']);
    }
}
