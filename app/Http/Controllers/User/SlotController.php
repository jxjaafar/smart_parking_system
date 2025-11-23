<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{
    // Show available parking slots
    public function index()
    {
        $slots = ParkingSlot::all();
        return view('user.view-slots', compact('slots'));
    }
    
    // Booking form
    public function bookForm($id)
    {
        $slot = ParkingSlot::findOrFail($id);
        return view('user.slots.book', compact('slot'));
    }
    
    // Save booking
    public function storeBooking(Request $request, $id)
    {
        $slot = ParkingSlot::findOrFail($id);
        
        // Check if slot is still available
        if ($slot->status !== 'Available') {
            return redirect()->route('slots.index')
                ->with('error', 'This slot is no longer available.');
        }
        
        // Create reservation with start time
        Reservation::create([
            'userID' => Auth::id(),
            'slotID' => $slot->id,  // Changed from $slot->slotID to $slot->id
            'startTime' => now(),
            'reservationStatus' => 'Active',
            'paymentStatus' => 'Unpaid'
        ]);
        
        // Update slot status
        $slot->status = 'Occupied';
        $slot->save();
        
        return redirect()->route('user.reservations.index')
            ->with('success', 'Slot booked successfully! Timer started.');
    }
}