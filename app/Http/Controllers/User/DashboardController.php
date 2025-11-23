<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // This should return the view with Quick Actions (Image 1)
        return view('user.dashboard'); // Or whatever your proper dashboard blade is
    }
}