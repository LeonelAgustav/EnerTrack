<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnerTrack - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #EEF2FF, #E0E7FF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .form-input {
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background: linear-gradient(to right, #3B82F6, #4F46E5);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto p-4">
        <div class="flex flex-wrap items-center">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center p-10">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-b from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center pulse-animation">
                        <i class="fas fa-bolt text-xl text-white"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">EnerTrack</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Join Our Energy-Saving Community</h1>
                <p class="text-gray-600 mb-6 text-center max-w-md">Create an account to track, analyze, and optimize your energy consumption</p>
                <div class="mt-8 bg-white/50 p-6 rounded-xl">
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Detailed Analytics</h3>
                            <p class="text-sm text-gray-600">Track your energy usage patterns</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Cost Savings</h3>
                            <p class="text-sm text-gray-600">Reduce your monthly energy bill</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-leaf text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Eco-Friendly</h3>
                            <p class="text-sm text-gray-600">Lower your carbon footprint</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="w-full max-w-lg lg:w-1/2 p-4 mx-auto">
                <div class="card bg-white rounded-3xl p-8">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Create Your Account</h2>
                        <p class="text-gray-600">Sign up to start tracking your energy usage</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                        <script src="{{ asset('js/register_redirect.js') }}"></script>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                        @csrf
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="fullName" class="block text-gray-700 text-sm font-medium mb-2">Full Name</label>
                                    <input type="text" id="fullName" name="fullName" placeholder="John Doe" required
                                        class="form-input w-full py-3 px-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('fullName') border-red-500 @enderror"
                                        value="{{ old('fullName') }}">
                                    @error('fullName')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                                    <input type="text" id="username" name="username" placeholder="johndoe" required
                                        class="form-input w-full py-3 px-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('username') border-red-500 @enderror"
                                        value="{{ old('username') }}">
                                    @error('username')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email" placeholder="your@email.com" required
                                        class="form-input w-full py-3 pl-10 pr-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('email') border-red-500 @enderror"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" name="password" placeholder="••••••••" required
                                        class="form-input w-full py-3 pl-10 pr-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('password') border-red-500 @enderror">
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="mt-1">
                                    <div class="flex space-x-1 mb-1">
                                        <div class="h-1 flex-1 rounded bg-gray-200" id="strength-1"></div>
                                        <div class="h-1 flex-1 rounded bg-gray-200" id="strength-2"></div>
                                        <div class="h-1 flex-1 rounded bg-gray-200" id="strength-3"></div>
                                        <div class="h-1 flex-1 rounded bg-gray-200" id="strength-4"></div>
                                    </div>
                                    <p class="text-xs text-gray-500">Use 8+ characters with a mix of letters, numbers & symbols</p>
                                </div>
                            </div>

                            <div>
                                <label for="confirmPassword" class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••" required
                                        class="form-input w-full py-3 pl-10 pr-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('confirmPassword') border-red-500 @enderror">
                                </div>
                                @error('confirmPassword')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="terms" class="ml-2 text-sm text-gray-600">
                                    I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                                </label>
                            </div>

                            <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Create Account
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-gray-600 text-sm">
                        Already have an account? <a href="{{ url('/login') }}" class="text-blue-600 font-medium hover:text-blue-800">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Password strength indicator
            const passwordField = document.getElementById('password');
            const strength1 = document.getElementById('strength-1');
            const strength2 = document.getElementById('strength-2');
            const strength3 = document.getElementById('strength-3');
            const strength4 = document.getElementById('strength-4');

            passwordField.addEventListener('input', function() {
                const val = passwordField.value;
                let score = 0;
                
                // Reset strength indicators
                [strength1, strength2, strength3, strength4].forEach(el => {
                    el.classList.remove('bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-400');
                    el.classList.add('bg-gray-200');
                });

                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                if (score >= 1) {
                    strength1.classList.remove('bg-gray-200');
                    strength1.classList.add('bg-red-400');
                }
                if (score >= 2) {
                    strength2.classList.remove('bg-gray-200');
                    strength2.classList.add('bg-orange-400');
                }
                if (score >= 3) {
                    strength3.classList.remove('bg-gray-200');
                    strength3.classList.add('bg-yellow-400');
                }
                if (score >= 4) {
                    strength4.classList.remove('bg-gray-200');
                    strength4.classList.add('bg-green-400');
                }
            });
        });
    </script>
</body>

</html>