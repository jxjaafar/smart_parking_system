<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    protected $table = 'Reservation';
    protected $primaryKey = 'reservationID';
    public $timestamps = false; 
    
    protected $fillable = [
        'userID',
        'vehicleID', 
        'slotID',
        'startTime',
        'endTime',
        'totalHours',
        'totalCost',
        'paymentStatus',
        'reservationStatus'
    ];
    
    protected $casts = [
        'startTime' => 'datetime',
        'endTime' => 'datetime',
        'createdAt' => 'datetime',
        'totalCost' => 'decimal:2'
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
    
    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slotID', 'id');  // Changed from 'slotID' to 'id'
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleID', 'vehicleID');
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'reservationID', 'reservationID');
    }
    
    // Helper method to calculate elapsed time
    public function getElapsedTimeAttribute()
    {
        if (!$this->startTime) return 0;
        
        $end = $this->endTime ?? now();
        return $this->startTime->diffInMinutes($end);
    }
    
    // Helper method to calculate current cost
    public function getCurrentCostAttribute()
    {
        if (!$this->startTime || !$this->parkingSlot) return 0;
        
        $minutes = $this->elapsed_time;
        $hours = ceil($minutes / 60); // Round up to nearest hour
        
        return $hours * $this->parkingSlot->pricePerHour;
    }
}