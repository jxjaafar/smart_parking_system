<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $query = ParkingSlot::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('slotNumber', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $parkingSlots = $query->orderBy('id')->get();
        
        // Get statistics
        $stats = [
            'total' => ParkingSlot::count(),
            'available' => ParkingSlot::where('status', 'Available')->count(),
            'occupied' => ParkingSlot::where('status', 'Occupied')->count(),
            'maintenance' => ParkingSlot::where('status', 'Maintenance')->count(),
        ];
        
        return view('admin.parking-slots.index', compact('parkingSlots', 'stats'));
    }

    public function create()
    {
        return view('admin.parking-slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'slotNumber' => 'required|unique:parking_slots,slotNumber',
            'location' => 'required|string|max:255',
            'pricePerHour' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
            'description' => 'nullable|string|max:500'
        ]);

        ParkingSlot::create([
            'slotNumber' => $request->slotNumber,
            'location' => $request->location,
            'pricePerHour' => $request->pricePerHour,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('parking-slots.index')
                         ->with('success', 'Parking slot created successfully.');
    }

    public function edit($id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        return view('admin.parking-slots.edit', compact('parkingSlot'));
    }

    public function update(Request $request, $id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        
        $request->validate([
            'slotNumber' => 'required|unique:parking_slots,slotNumber,' . $id,
            'location' => 'required|string|max:255',
            'pricePerHour' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
            'description' => 'nullable|string|max:500'
        ]);

        $parkingSlot->update([
            'slotNumber' => $request->slotNumber,
            'location' => $request->location,
            'pricePerHour' => $request->pricePerHour,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('parking-slots.index')
                         ->with('success', 'Parking slot updated successfully.');
    }

    public function destroy($id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        
        // Check if slot has active reservations
        if ($parkingSlot->reservations()->where('reservationStatus', 'Active')->exists()) {
            return redirect()->route('parking-slots.index')
                           ->with('error', 'Cannot delete slot with active reservations.');
        }
        
        $parkingSlot->delete();
        
        return redirect()->route('parking-slots.index')
                         ->with('success', 'Parking slot deleted successfully.');
    }
}