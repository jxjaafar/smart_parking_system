<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ParkSmart - Find, Reserve, and Park with Ease</title>
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
@keyframes float {
0%, 100% { transform: translateY(0px); }
50% { transform: translateY(-10px); }
}
.fade-in { animation: fadeIn 0.8s ease-out; }
.slide-in { animation: slideIn 0.6s ease-out; }
.float { animation: float 3s ease-in-out infinite; }
.gradient-bg {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.gradient-text {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}
.btn-primary {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
transition: all 0.3s ease;
}
.btn-primary:hover {
transform: translateY(-2px);
box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}
.card-hover {
transition: all 0.3s ease;
}
.card-hover:hover {
transform: translateY(-5px);
}
</style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<!-- Hero Section -->
<div class="gradient-bg text-white">
<!-- Navigation Bar -->
<nav class="container mx-auto px-6 py-6">
<div class="flex justify-center items-center">
<div class="flex items-center space-x-3">
<span class="text-4xl">🚘</span>
<span class="text-2xl font-bold">ParkSmart</span>
</div>
</div>
</nav>

<!-- Hero Content -->
<div class="container mx-auto px-6 py-20 text-center fade-in">
<div class="max-w-4xl mx-auto">
<h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
Find, Reserve, and Park<br/>with Ease
</h1>
<p class="text-xl md:text-2xl text-purple-100 mb-8 leading-relaxed">
Say goodbye to parking hassles. ParkSmart helps you find and book parking spots instantly, saving you time and stress.
</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
<a href="{{ route('register') }}" class="px-8 py-4 bg-white text-purple-600 rounded-xl font-bold text-lg hover:bg-gray-100 transition shadow-xl hover:shadow-2xl">
🚀 Get Started (Register)
</a>
<a href="{{ route('login') }}" class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/30 transition">
Sign In →
</a>
</div>
<div class="mt-12 flex justify-center gap-8 text-sm">
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
<span class="font-semibold">Real-time</span> Availability
</div>
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
<span class="font-semibold">Instant</span> Booking
</div>
<div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
<span class="font-semibold">Secure</span> Payment
</div>
</div>
</div>
</div>
</div>

<!-- Features Section -->
<div class="container mx-auto px-6 py-20">
<div class="text-center mb-16 slide-in">
<h2 class="text-4xl font-bold gradient-text mb-4">Why Choose ParkSmart?</h2>
<p class="text-xl text-gray-600">Everything you need for hassle-free parking</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="bg-white rounded-2xl p-8 shadow-lg card-hover text-center fade-in">
<div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6 float">
<span class="text-4xl">⚡</span>
</div>
<h3 class="text-2xl font-bold text-gray-800 mb-4">Instant Booking</h3>
<p class="text-gray-600 leading-relaxed">
Reserve your parking spot in seconds with our streamlined booking system. No more driving around searching!
</p>
</div>

<div class="bg-white rounded-2xl p-8 shadow-lg card-hover text-center fade-in" style="animation-delay: 0.1s;">
<div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6 float" style="animation-delay: 0.5s;">
<span class="text-4xl">💰</span>
</div>
<h3 class="text-2xl font-bold text-gray-800 mb-4">Best Prices</h3>
<p class="text-gray-600 leading-relaxed">
Competitive hourly rates with transparent pricing. No hidden fees, no surprises - just fair prices.
</p>
</div>

<div class="bg-white rounded-2xl p-8 shadow-lg card-hover text-center fade-in" style="animation-delay: 0.2s;">
<div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-6 float" style="animation-delay: 1s;">
<span class="text-4xl">🔒</span>
</div>
<h3 class="text-2xl font-bold text-gray-800 mb-4">Secure & Safe</h3>
<p class="text-gray-600 leading-relaxed">
24/7 monitoring and security for complete peace of mind. Your vehicle is always protected.
</p>
</div>
</div>
</div>

<!-- How It Works Section -->
<div class="bg-white py-20">
<div class="container mx-auto px-6">
<div class="text-center mb-16">
<h2 class="text-4xl font-bold gradient-text mb-4">How It Works</h2>
<p class="text-xl text-gray-600">Get parked in 3 simple steps</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
<div class="text-center">
<div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
1
</div>
<h3 class="text-xl font-bold text-gray-800 mb-3">Create Account</h3>
<p class="text-gray-600">Sign up in seconds and set up your profile with your vehicle details.</p>
</div>

<div class="text-center">
<div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
2
</div>
<h3 class="text-xl font-bold text-gray-800 mb-3">Find & Book</h3>
<p class="text-gray-600">Browse available slots, choose your spot, and reserve instantly.</p>
</div>

<div class="text-center">
<div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
3
</div>
<h3 class="text-xl font-bold text-gray-800 mb-3">Park & Go</h3>
<p class="text-gray-600">Arrive at your reserved spot and park with confidence. It's that easy!</p>
</div>
</div>
</div>
</div>

<!-- CTA Section -->
<div class="container mx-auto px-6 py-20">
<div class="gradient-bg rounded-3xl p-12 text-center text-white shadow-2xl">
<h2 class="text-4xl font-bold mb-6">System Administration</h2>
<p class="text-xl mb-8 text-purple-100">Access the admin dashboard to manage parking slots and reservations</p>
<div class="flex justify-center">
<a href="{{ route('admin.login') }}" class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white rounded-xl font-bold text-lg hover:bg-white/30 transition">
Admin Login
</a>
</div>
</div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8">
<div class="container mx-auto px-6 text-center">
<div class="flex items-center justify-center space-x-3 mb-4">
<span class="text-3xl">🚘</span>
<span class="text-xl font-bold text-white">ParkSmart</span>
</div>
<p class="text-sm">© 2024 ParkSmart. Making parking effortless.</p>
<div class="mt-4 flex justify-center gap-6 text-sm">
<a href="#" class="hover:text-white transition">About</a>
<a href="#" class="hover:text-white transition">Contact</a>
<a href="#" class="hover:text-white transition">Privacy</a>
<a href="#" class="hover:text-white transition">Terms</a>
</div>
</div>
</footer>
</body>
</html>