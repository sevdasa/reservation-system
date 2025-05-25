<?php

namespace App\Http\Controllers\Bookable;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
       return Inertia::render("Bookable/Dashboard/Index");
    }
}
