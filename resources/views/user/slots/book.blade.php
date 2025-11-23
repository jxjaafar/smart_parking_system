<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Slot - ParkSmart</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@keyframes fadeIn {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
@keyframes pulse {
0%, 100% { transform: scale(1); }
50% { transform: scale(1.05); }
}
.fade-in { animation: fadeIn 0.6s ease-out; }
.pulse-slow { animation: pulse 2s ease-in-out infinite; }
.gradient-bg {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-2xl fade-in">
<!-- Header -->
<div class="text-center mb-8">
<div class="text-6xl mb-4 pulse-slow">🅿️</div>
<h1 class="text-4xl font-bold text-gray-800 mb-2">Confirm Your Booking</h1>
<p class="text-gray-600">Review the details before reserving your spot</p>
</div>

<!-- Booking Card -->
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
<!-- Purple Header -->
<div class="gradient-bg text-white p-8 text-center">
<div class="text-6xl font-bold mb-2">{{ $slot->slotNumber }}</div>
<p class="text-xl text-purple-100">{{ $slot->location }}</p>
</div>

<!-- Details Section -->
<div class="p-8">
<!-- Status Badge -->
<div class="flex justify-center mb-6">
<div class="bg-green-100 text-green-700 px-6 py-2 rounded-full font-bold text-sm">
✅ Available Now
</div>
</div>

<!-- Pricing -->
<div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-6 mb-6">
<div class="text-center">
<p class="text-gray-600 text-sm mb-2">Hourly Rate</p>
<div class="flex items-baseline justify-center">
<span class="text-5xl font-bold text-gray-800">KES {{ number_format($slot->pricePerHour) }}</span>
<span class="text-xl text-gray-600 ml-2">/hour</span>
</div>
<p class="text-xs text-gray-500 mt-3">💡 Billed per hour • Pay when you leave</p>
</div>
</div>

<!-- Features -->
<div class="grid grid-cols-2 gap-4 mb-8">
<div class="bg-gray-50 rounded-xl p-4 text-center">
<div class="text-3xl mb-2">⏱️</div>
<p class="text-sm font-semibold text-gray-700">Instant Start</p>
<p class="text-xs text-gray-500">Timer begins immediately</p>
</div>
<div class="bg-gray-50 rounded-xl p-4 text-center">
<div class="text-3xl mb-2">🔒</div>
<p class="text-sm font-semibold text-gray-700">Secure & Safe</p>
<p class="text-xs text-gray-500">24/7 monitoring</p>
</div>
<div class="bg-gray-50 rounded-xl p-4 text-center">
<div class="text-3xl mb-2">💳</div>
<p class="text-sm font-semibold text-gray-700">Pay on Exit</p>
<p class="text-xs text-gray-500">No upfront payment</p>
</div>
<div class="bg-gray-50 rounded-xl p-4 text-center">
<div class="text-3xl mb-2">📱</div>
<p class="text-sm font-semibold text-gray-700">Real-time Tracking</p>
<p class="text-xs text-gray-500">Monitor time & cost</p>
</div>
</div>

<!-- Important Notice -->
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-xl">
<div class="flex items-start">
<span class="text-2xl mr-3">⚠️</span>
<div>
<p class="text-sm font-semibold text-yellow-800 mb-1">Important</p>
<p class="text-xs text-yellow-700">Your timer will start immediately upon confirmation. You can end your reservation anytime from "My Reservations" page.</p>
</div>
</div>
</div>

<!-- Actions -->
<form action="{{ route('user.slots.book.store', $slot->id) }}" method="POST" class="space-y-4">
@csrf
<button type="submit" class="w-full gradient-bg text-white font-bold py-4 px-6 rounded-xl hover:opacity-90 transition shadow-lg text-lg">
🚀 Confirm Booking & Start Timer
</button>
</form>

<a href="{{ route('slots.index') }}" class="block text-center text-gray-600 hover:text-gray-800 mt-4 font-semibold">
← Back to Available Slots
</a>
</div>
</div>
</div>

</body>
</html>