<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $stats = [
            'total_users' => User::count(),
            'total_slots' => ParkingSlot::count(),
            'available_slots' => ParkingSlot::where('status', 'Available')->count(),
            'occupied_slots' => ParkingSlot::where('status', 'Occupied')->count(),
            'active_reservations' => Reservation::where('reservationStatus', 'Active')->count(),
            'total_revenue' => Payment::where('status', 'Completed')->sum('amount'),
        ];

        // Get recent reservations
        $recent_reservations = Reservation::with(['user', 'parkingSlot'])
            ->orderBy('createdAt', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_reservations'));
    }
}