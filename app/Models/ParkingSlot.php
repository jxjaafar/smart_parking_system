<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;
    
    protected $table = 'parking_slots';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    
    protected $fillable = [
        'slotNumber',
        'location',
        'status',
        'pricePerHour',
        'description'
    ];
    
    protected $casts = [
        'pricePerHour' => 'decimal:2'
    ];
    
    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'slotID', 'id');
    }
    
    public function ratings()
    {
        return $this->hasMany(ServiceRating::class, 'slotID', 'id');
    }
    
    // Scope for available slots
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available');
    }
    
    // Scope for occupied slots
    public function scopeOccupied($query)
    {
        return $query->where('status', 'Occupied');
    }
    
    // Scope for maintenance slots
    public function scopeMaintenance($query)
    {
        return $query->where('status', 'Maintenance');
    }
}