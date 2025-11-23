<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Reservations - ParkSmart</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@keyframes fadeIn {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
.fade-in { animation: fadeIn 0.6s ease-out; }
.gradient-bg {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.card-hover {
transition: all 0.3s ease;
}
.card-hover:hover {
transform: translateY(-5px);
box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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
📋 My Reservations
</h1>
<p class="text-xl text-purple-100">
Manage your parking bookings
</p>
</div>
</div>
</div>

<div class="container mx-auto px-6 max-w-7xl pb-12">

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-6 fade-in">
✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-6 fade-in">
❌ {{ session('error') }}
</div>
@endif

@if($reservations->where('reservationStatus', 'Active')->count() > 0)
<!-- Active Reservations -->
<div class="mb-8">
<h2 class="text-2xl font-bold text-gray-800 mb-4">🟢 Active Reservations</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@foreach($reservations->where('reservationStatus', 'Active') as $reservation)
<div class="bg-white rounded-2xl shadow-lg p-6 card-hover fade-in">
<!-- Header -->
<div class="flex justify-between items-start mb-4">
<div>
<h3 class="text-3xl font-bold text-gray-800">{{ $reservation->parkingSlot->slotNumber }}</h3>
<p class="text-gray-600 text-sm mt-1">
<span class="inline-block mr-1">📍</span>
{{ $reservation->parkingSlot->location }}
</p>
</div>
<div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
Active
</div>
</div>

<!-- Timer & Cost -->
<div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-4 mb-4">
<div class="grid grid-cols-2 gap-4">
<div>
<p class="text-xs text-gray-600 mb-1">Time Elapsed</p>
<p class="text-2xl font-bold text-gray-800" id="timer-{{ $reservation->reservationID }}">
Calculating...
</p>
</div>
<div>
<p class="text-xs text-gray-600 mb-1">Current Cost</p>
<p class="text-2xl font-bold text-purple-600" id="cost-{{ $reservation->reservationID }}">
KES 0
</p>
</div>
</div>
</div>

<!-- Details -->
<div class="space-y-2 mb-4 text-sm">
<div class="flex justify-between">
<span class="text-gray-600">⏰ Started:</span>
<span class="font-semibold">{{ $reservation->startTime->format('M d, Y - h:i A') }}</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">💰 Rate:</span>
<span class="font-semibold">KES {{ number_format($reservation->parkingSlot->pricePerHour) }}/hour</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">💳 Payment:</span>
<span class="font-semibold text-orange-600">{{ $reservation->paymentStatus }}</span>
</div>
</div>

<!-- Actions -->
<form action="{{ route('user.reservations.end', $reservation->reservationID) }}" method="POST">
@csrf
<button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-3 px-6 rounded-xl hover:opacity-90 transition shadow-lg">
🚪 End Reservation & Pay
</button>
</form>
</div>

<script>
// Real-time timer and cost calculator
(function() {
    const startTime = new Date("{{ $reservation->startTime->toIso8601String() }}");
    const pricePerHour = {{ $reservation->parkingSlot->pricePerHour }};
    const timerEl = document.getElementById('timer-{{ $reservation->reservationID }}');
    const costEl = document.getElementById('cost-{{ $reservation->reservationID }}');
    
    function update() {
        const now = new Date();
        const diffMs = now - startTime;
        const minutes = Math.floor(diffMs / 60000);
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        
        // Update timer
        timerEl.textContent = `${hours}h ${mins}m`;
        
        // Calculate cost (round up to nearest hour)
        const billableHours = Math.ceil(minutes / 60);
        const cost = billableHours * pricePerHour;
        costEl.textContent = `KES ${cost.toLocaleString()}`;
    }
    
    update();
    setInterval(update, 1000); // Update every second
})();
</script>
@endforeach
</div>
</div>
@endif

@if($reservations->where('reservationStatus', 'Completed')->count() > 0)
<!-- Completed Reservations -->
<div class="mb-8">
<h2 class="text-2xl font-bold text-gray-800 mb-4">✅ Completed Reservations</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@foreach($reservations->where('reservationStatus', 'Completed') as $reservation)
<div class="bg-white rounded-2xl shadow-lg p-6 fade-in opacity-75">
<div class="flex justify-between items-start mb-4">
<div>
<h3 class="text-2xl font-bold text-gray-800">{{ $reservation->parkingSlot->slotNumber }}</h3>
<p class="text-gray-600 text-sm">{{ $reservation->parkingSlot->location }}</p>
</div>
<div class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
Completed
</div>
</div>

<div class="space-y-2 text-sm">
<div class="flex justify-between">
<span class="text-gray-600">Duration:</span>
<span class="font-semibold">{{ $reservation->totalHours }} hours</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Total Cost:</span>
<span class="font-semibold text-purple-600">KES {{ number_format($reservation->totalCost) }}</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Payment:</span>
<span class="font-semibold {{ $reservation->paymentStatus === 'Paid' ? 'text-green-600' : 'text-red-600' }}">
{{ $reservation->paymentStatus }}
</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Ended:</span>
<span class="font-semibold">{{ $reservation->endTime ? $reservation->endTime->format('M d, Y - h:i A') : 'N/A' }}</span>
</div>
</div>
</div>
@endforeach
</div>
</div>
@endif

@if($reservations->count() === 0)
<!-- No Reservations -->
<div class="bg-white rounded-2xl shadow-xl p-16 text-center fade-in">
<div class="text-6xl mb-4">📋</div>
<h3 class="text-2xl font-bold text-gray-700 mb-2">No Reservations Yet</h3>
<p class="text-gray-500 mb-6">Book a parking slot to see your reservations here.</p>
<a href="{{ route('slots.index') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition">
View Available Slots
</a>
</div>
@endif

</div>

<!-- Footer -->
<div class="mt-12 pb-8 text-center text-gray-600">
<p class="text-sm">© 2024 ParkSmart. Making parking effortless.</p>
</div>

</body>
</html>