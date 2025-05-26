<?php

namespace App\Http\Controllers\Bookable;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('bookable')->user();
        // dd($user->bookable->TimeSlot);
        $slots = $user->bookable->TimeSlot()->with('reservations.user')->get();

        // dd($slots);
        return Inertia::render('Bookable/Dashboard/Index', [
            'slots' => $slots,
            'user' => $user,
        ]);
    }
}
