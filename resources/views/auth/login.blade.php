<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ParkSmart</title>
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
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md fade-in">
        <!-- Logo and Back Button -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-purple-600 transition mb-6">
                <span class="text-xl mr-2">←</span>
                <span class="font-semibold">Back to Home</span>
            </a>
            <div class="flex items-center justify-center space-x-3 mb-4">
                <span class="text-5xl">🚘</span>
                <span class="text-3xl font-bold gradient-bg bg-clip-text text-transparent">ParkSmart</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-gray-600 mt-2">Sign in to continue parking smart</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="input-field w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none"
                        placeholder="you@example.com"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="input-field w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                            class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-2 cursor-pointer"
                        >
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 font-semibold transition">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full gradient-bg text-white font-bold py-3 px-6 rounded-lg hover:opacity-90 transition shadow-lg hover:shadow-xl"
                >
                    Sign In
                </button>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700 transition">
                            Create Account
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>© 2024 ParkSmart. Making parking effortless.</p>
        </div>
    </div>
</body>
</html>