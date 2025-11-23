<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('fullName', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phoneNumber', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('dateRegistered', 'desc')->get();
        
        // Get statistics
        $stats = [
            'total' => User::count(),
            'drivers' => User::where('role', 'Driver')->count(),
            'admins' => User::where('role', 'Admin')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show($id)
    {
        $user = User::with(['reservations.parkingSlot', 'vehicles'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->userID == auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot delete your own account.');
        }
        
        // Prevent deleting if user has active reservations
        if ($user->reservations()->where('reservationStatus', 'Active')->exists()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot delete user with active reservations.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}