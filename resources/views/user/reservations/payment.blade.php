<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment - ParkSmart</title>
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
</style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-md fade-in">
<!-- Payment Card -->
<div class="bg-white rounded-2xl shadow-xl p-8">
<div class="text-center mb-6">
<div class="text-6xl mb-4">💳</div>
<h1 class="text-3xl font-bold text-gray-800">Payment Required</h1>
<p class="text-gray-600 mt-2">Complete your parking session</p>
</div>

<!-- Reservation Details -->
<div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-6 mb-6">
<div class="space-y-3">
<div class="flex justify-between">
<span class="text-gray-700">Slot:</span>
<span class="font-bold text-gray-900">{{ $reservation->parkingSlot->slotNumber }}</span>
</div>
<div class="flex justify-between">
<span class="text-gray-700">Location:</span>
<span class="font-bold text-gray-900">{{ $reservation->parkingSlot->location }}</span>
</div>
<div class="flex justify-between">
<span class="text-gray-700">Duration:</span>
<span class="font-bold text-gray-900">{{ $reservation->totalHours }} hours</span>
</div>
<div class="flex justify-between">
<span class="text-gray-700">Rate:</span>
<span class="font-bold text-gray-900">KES {{ number_format($reservation->parkingSlot->pricePerHour) }}/hour</span>
</div>
<hr class="my-2">
<div class="flex justify-between text-xl">
<span class="text-gray-700 font-semibold">Total Amount:</span>
<span class="font-bold text-purple-600">KES {{ number_format($reservation->totalCost) }}</span>
</div>
</div>
</div>

<!-- Time Details -->
<div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm">
<div class="flex justify-between mb-2">
<span class="text-gray-600">Started:</span>
<span class="font-semibold">{{ $reservation->startTime->format('M d, Y - h:i A') }}</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Ended:</span>
<span class="font-semibold">{{ $reservation->endTime->format('M d, Y - h:i A') }}</span>
</div>
</div>

<!-- Payment Button -->
<form action="{{ route('user.reservations.pay', $reservation->reservationID) }}" method="POST">
@csrf
<button type="submit" class="w-full gradient-bg text-white font-bold py-4 px-6 rounded-xl hover:opacity-90 transition shadow-lg mb-3">
💰 Complete Payment (KES {{ number_format($reservation->totalCost) }})
</button>
</form>

<a href="{{ route('user.reservations.index') }}" class="block text-center text-gray-600 hover:text-gray-800 text-sm">
← Back to Reservations
</a>
</div>

<!-- Note -->
<div class="mt-6 text-center text-sm text-gray-500">
<p>🔒 This is a simulated payment. No real transaction will occur.</p>
</div>
</div>

</body>
</html>