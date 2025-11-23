<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ParkSmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.6s ease-out; }
        .admin-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #312e81 100%);
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md fade-in">
        <!-- Logo and Back Button -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-gray-400 hover:text-white transition mb-6">
                <span class="text-xl mr-2">←</span>
                <span class="font-semibold">Back to Home</span>
            </a>
            <div class="flex items-center justify-center space-x-3 mb-4">
                <span class="text-5xl">⚙️</span>
                <span class="text-3xl font-bold text-white">ParkSmart</span>
            </div>
            <div class="inline-block px-4 py-2 bg-blue-900/50 rounded-full mb-4">
                <span class="text-blue-300 font-semibold text-sm">🔒 Admin Access</span>
            </div>
            <h1 class="text-2xl font-bold text-white">Administrator Login</h1>
            <p class="text-gray-400 mt-2">Secure access to system management</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-slate-800 rounded-2xl shadow-2xl p-8 border border-slate-700">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-900/50 border border-green-700 text-green-300 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-900/50 border border-red-700 text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                        Admin Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="input-field w-full px-4 py-3 rounded-lg bg-slate-900 border-2 border-slate-600 text-white focus:border-blue-500 focus:outline-none placeholder-gray-500"
                        placeholder="admin@parksmart.com"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="input-field w-full px-4 py-3 rounded-lg bg-slate-900 border-2 border-slate-600 text-white focus:border-blue-500 focus:outline-none placeholder-gray-500"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember" class="inline-flex items-center cursor-pointer">
                        <input 
                            id="remember" 
                            type="checkbox" 
                            name="remember"
                            class="rounded border-slate-600 bg-slate-900 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-2 cursor-pointer"
                        >
                        <span class="ml-2 text-sm text-gray-400">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full admin-gradient text-white font-bold py-3 px-6 rounded-lg hover:opacity-90 transition shadow-lg hover:shadow-xl"
                >
                    🔐 Access Admin Dashboard
                </button>

                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-slate-900/50 border border-slate-700 rounded-lg">
                    <div class="flex items-start">
                        <span class="text-yellow-500 mr-2">⚠️</span>
                        <p class="text-xs text-gray-400">
                            This is a restricted area. All login attempts are monitored and logged for security purposes.
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>© 2024 ParkSmart Admin Portal</p>
        </div>
    </div>
</body>
</html>