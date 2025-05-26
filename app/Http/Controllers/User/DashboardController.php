<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
   public function index()
    {
        $reservations=Reservation::where('user_id', Auth::guard('web')->id())
            ->with(['timeSlot', 'timeSlot.bookable'])
            ->paginate(10);
        return Inertia::render('User/Dashboard', [
            'user' => Auth::guard('web')->user(),
            'reservations' => $reservations,
        ]);
    }
}
