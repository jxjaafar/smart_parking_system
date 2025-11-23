<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('userID', Auth::id())
            ->with('parkingSlot')
            ->orderBy('startTime', 'desc')
            ->get();
            
        return view('user.reservations.index', compact('reservations'));
    }

    public function endReservation($id)
    {
        $reservation = Reservation::where('reservationID', $id)
            ->where('userID', Auth::id())
            ->firstOrFail();

        // Calculate final cost
        $endTime = now();
        $minutes = $reservation->startTime->diffInMinutes($endTime);
        $hours = ceil($minutes / 60); // Round up to nearest hour
        $totalCost = $hours * $reservation->parkingSlot->pricePerHour;

        // Update reservation
        $reservation->endTime = $endTime;
        $reservation->totalHours = $hours;
        $reservation->totalCost = $totalCost;
        $reservation->reservationStatus = 'Completed';
        $reservation->save();

        // Show payment page
        return view('user.reservations.payment', compact('reservation'));
    }

    public function processPayment(Request $request, $id)
{
    $reservation = Reservation::where('reservationID', $id)
        ->where('userID', Auth::id())
        ->firstOrFail();

    // Mark as paid
    $reservation->paymentStatus = 'Paid';
    $reservation->save();

    // Free the slot - FIXED: using 'id' not 'slotID'
    $slot = \DB::table('parking_slots')
        ->where('id', $reservation->slotID)
        ->update(['status' => 'Available']);

    return redirect()->route('user.reservations.index')
        ->with('success', 'Payment successful! Slot has been released.');
}

    public function destroy($id)
    {
        $reservation = Reservation::where('reservationID', $id)
            ->where('userID', Auth::id())
            ->firstOrFail();

        // Free the slot
        $slot = ParkingSlot::where('slotID', $reservation->slotID)->first();
        if ($slot) {
            $slot->status = 'Available';
            $slot->save();
        }

        $reservation->delete();

        return redirect()->back()->with('success', 'Reservation cancelled');
    }
}