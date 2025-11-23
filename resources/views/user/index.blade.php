<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Smart Parking System - Find Your Perfect Spot</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@keyframes fadeIn {
from { opacity: 0; transform: translateY(20px); }
to { opacity: 1; transform: translateY(0); }
}
@keyframes slideIn {
from { opacity: 0; transform: translateX(-20px); }
to { opacity: 1; transform: translateX(0); }
}
@keyframes pulse-subtle {
0%, 100% { transform: scale(1); }
50% { transform: scale(1.02); }
}
.fade-in { animation: fadeIn 0.6s ease-out; }
.slide-in { animation: slideIn 0.5s ease-out; }
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
.gradient-text {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
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
</style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<!-- Hero Section -->
<div class="gradient-bg text-white py-16 mb-8 fade-in">
<div class="container mx-auto px-6">
<div class="max-w-4xl mx-auto text-center">
<h1 class="text-5xl md:text-6xl font-bold mb-4">
🚗 ParkSmart
</h1>
<p class="text-xl md:text-2xl text-purple-100 mb-8">
Find, Reserve, and Park with Ease
</p>
<div class="flex justify-center gap-4 text-sm">
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
<span class="font-semibold">Real-time</span> Availability
</div>
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
<span class="font-semibold">Instant</span> Booking
</div>
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
<span class="font-semibold">Secure</span> Payment
</div>
</div>
</div>
</div>
</div>

<div class="container mx-auto px-6 max-w-7xl">
<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-xl p-8 mb-8 slide-in">
<h2 class="text-2xl font-bold text-gray-800 mb-6">Quick Actions</h2>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
<a href="{{ route('view-slots') }}" class="group flex flex-col items-center p-4 rounded-xl hover:bg-blue-50 transition">
<div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">🔍</span>
</div>
<span class="text-sm font-semibold text-gray-700">View Slots</span>
</a>

<a href="{{ route('user.reservations.index') }}" class="group flex flex-col items-center p-4 rounded-xl hover:bg-green-50 transition">
<div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">📋</span>
</div>
<span class="text-sm font-semibold text-gray-700">Reservations</span>
</a>

@auth
<form action="{{ route('logout') }}" method="POST" class="group flex flex-col items-center p-4 rounded-xl hover:bg-red-50 transition cursor-pointer">
@csrf
<button type="submit" class="w-full flex flex-col items-center">
<div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">🚪</span>
</div>
<span class="text-sm font-semibold text-gray-700">Logout</span>
</button>
</form>
@else
<a href="{{ route('login') }}" class="group flex flex-col items-center p-4 rounded-xl hover:bg-indigo-50 transition">
<div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">🔐</span>
</div>
<span class="text-sm font-semibold text-gray-700">Login</span>
</a>

<a href="{{ route('register') }}" class="group flex flex-col items-center p-4 rounded-xl hover:bg-purple-50 transition">
<div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">✨</span>
</div>
<span class="text-sm font-semibold text-gray-700">Register</span>
</a>
@endauth

<a href="{{ route('admin.login') }}" class="group flex flex-col items-center p-4 rounded-xl hover:bg-purple-50 transition">
<div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
<span class="text-2xl">⚙️</span>
</div>
<span class="text-sm font-semibold text-gray-700">Admin</span>
</a>
</div>
</div>

<!-- Features Section -->
<div class="bg-white rounded-2xl shadow-xl p-8 fade-in">
<h2 class="text-3xl font-bold gradient-text mb-6 text-center">Why Choose Smart Parking?</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="text-center">
<div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
<span class="text-4xl">⚡</span>
</div>
<h3 class="text-xl font-bold text-gray-800 mb-2">Instant Booking</h3>
<p class="text-gray-600">Reserve your parking spot in seconds with our streamlined booking system.</p>
</div>
<div class="text-center">
<div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
<span class="text-4xl">💰</span>
</div>
<h3 class="text-xl font-bold text-gray-800 mb-2">Best Prices</h3>
<p class="text-gray-600">Competitive hourly rates with transparent pricing and no hidden fees.</p>
</div>
<div class="text-center">
<div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
<span class="text-4xl">🔒</span>
</div>
<h3 class="text-xl font-bold text-gray-800 mb-2">Secure & Safe</h3>
<p class="text-gray-600">24/7 monitoring and security for complete peace of mind.</p>
</div>
</div>
</div>
</div>

<!-- Footer -->
<div class="mt-12 pb-8 text-center text-gray-600">
<p class="text-sm">© 2024 Smart Parking System. Making parking effortless.</p>
</div>
</body>
</html>