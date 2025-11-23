<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Available Parking Slots - Smart Parking System</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@keyframes fadeIn {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
.fade-in { animation: fadeIn 0.6s ease-out; }
.card-hover {
transition: all 0.3s ease;
}
.card-hover:hover {
transform: translateY(-8px);
box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}
.gradient-bg {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.slot-card {
background: linear-gradient(to bottom right, #ffffff, #f8fafc);
border: 2px solid transparent;
transition: all 0.3s ease;
}
.slot-card:hover {
border-color: #667eea;
background: white;
}
.btn-primary {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
transition: all 0.3s ease;
}
.btn-primary:hover {
transform: scale(1.05);
box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}
.tab-button {
transition: all 0.3s ease;
}
.tab-button.active {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
color: white;
}
.floor-section {
display: none;
}
.floor-section.active {
display: block;
}
</style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<!-- Header -->
<div class="gradient-bg text-white py-12 mb-8 fade-in">
<div class="container mx-auto px-6">
<div class="max-w-4xl mx-auto">
<a href="{{ route('dashboard') }}" class="inline-flex items-center text-white/90 hover:text-white mb-4 transition">
<span class="text-2xl mr-2">←</span>
<span class="font-semibold">Back to Dashboard</span>
</a>
<h1 class="text-4xl md:text-5xl font-bold mb-3">
🔍 Available Parking Slots
</h1>
<p class="text-xl text-purple-100">
Find and book your perfect parking spot
</p>
</div>
</div>
</div>

<div class="container mx-auto px-6 max-w-7xl pb-12">
<!-- Stats Bar -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8 fade-in">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
<div>
<div class="text-3xl font-bold text-green-600">{{ $slots->where('status', 'Available')->count() }}</div>
<div class="text-gray-600 mt-1">Available Slots</div>
</div>
<div>
<div class="text-3xl font-bold text-red-600">{{ $slots->where('status', 'Occupied')->count() }}</div>
<div class="text-gray-600 mt-1">Occupied Slots</div>
</div>
<div>
<div class="text-3xl font-bold text-purple-600">{{ $slots->count() }}</div>
<div class="text-gray-600 mt-1">Total Slots</div>
</div>
</div>
</div>

@if($slots->count() > 0)
<!-- Floor Tabs -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8 fade-in">
<div class="flex flex-wrap gap-3">
@php
$floors = $slots->groupBy('location');
$floorOrder = ['Ground Floor', '1st Floor', '2nd Floor', '3rd Floor', '4th Floor'];
@endphp

@foreach($floorOrder as $index => $floorName)
@if($floors->has($floorName))
@php
$floorSlots = $floors[$floorName];
$availableCount = $floorSlots->where('status', 'Available')->count();
$price = $floorSlots->first()->pricePerHour ?? 0;
@endphp
<button 
onclick="switchFloor('{{ str_replace(' ', '-', strtolower($floorName)) }}')"
class="tab-button {{ $index === 0 ? 'active' : '' }} px-6 py-3 rounded-xl font-semibold transition"
id="tab-{{ str_replace(' ', '-', strtolower($floorName)) }}"
>
<div class="flex flex-col items-center">
<span class="text-lg">{{ $floorName }}</span>
<span class="text-xs opacity-80">{{ $availableCount }}/{{ $floorSlots->count() }} Available • KES {{ $price }}/hr</span>
</div>
</button>
@endif
@endforeach
</div>
</div>

<!-- Floor Sections -->
@foreach($floorOrder as $index => $floorName)
@if($floors->has($floorName))
<div 
id="floor-{{ str_replace(' ', '-', strtolower($floorName)) }}" 
class="floor-section {{ $index === 0 ? 'active' : '' }} fade-in"
>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
@foreach($floors[$floorName] as $slot)
<div class="slot-card rounded-xl p-6 shadow-md card-hover">
<div class="flex justify-between items-start mb-4">
<div>
<h3 class="text-xl font-bold text-gray-800">{{ $slot->slotNumber }}</h3>
<p class="text-gray-600 text-xs mt-1">
<span class="inline-block mr-1">📍</span>
{{ $slot->location }}
</p>
</div>
<div class="px-3 py-1 rounded-full text-xs font-bold
{{ $slot->status === 'Available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
{{ $slot->status }}
</div>
</div>

<div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-3 mb-4">
<div class="flex items-baseline">
<span class="text-2xl font-bold text-gray-800">KES {{ number_format($slot->pricePerHour, 0) }}</span>
<span class="text-gray-600 text-sm ml-2">/hour</span>
</div>
</div>

@if($slot->status === 'Available')
@auth
<a href="{{ route('user.slots.book', $slot->id) }}" 
class="btn-primary block text-center px-4 py-2 text-white font-semibold rounded-lg shadow-lg text-sm">
Book Now →
</a>
@else
<div class="text-center py-2 bg-gray-100 rounded-lg text-gray-600 text-xs">
<a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Login</a> to book
</div>
@endauth
@else
<button disabled class="w-full py-2 bg-gray-200 text-gray-500 rounded-lg text-sm font-semibold cursor-not-allowed">
Occupied
</button>
@endif
</div>
@endforeach
</div>
</div>
@endif
@endforeach

@else
<div class="bg-white rounded-2xl shadow-xl p-16 text-center fade-in">
<div class="text-6xl mb-4">🚫</div>
<h3 class="text-2xl font-bold text-gray-700 mb-2">No Available Slots</h3>
<p class="text-gray-500 mb-6">All parking spots are currently occupied. Check back soon!</p>
<a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition">
Return to Dashboard
</a>
</div>
@endif
</div>

<!-- Footer -->
<div class="mt-12 pb-8 text-center text-gray-600">
<p class="text-sm">© 2024 Smart Parking System. Making parking effortless.</p>
</div>

<script>
function switchFloor(floorId) {
    // Hide all floor sections
    document.querySelectorAll('.floor-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected floor section
    document.getElementById('floor-' + floorId).classList.add('active');
    
    // Add active class to clicked tab
    document.getElementById('tab-' + floorId).classList.add('active');
}
</script>
</body>
</html>