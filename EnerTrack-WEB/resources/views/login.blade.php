<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnerTrack - Login</title>
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

        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center lg:justify-between">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center p-10">
                <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full flex items-center justify-center mb-6 floating-icon">
                    <i class="fas fa-bolt text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">EnerTrack</h1>
                <p class="text-xl text-gray-600 mb-8 text-center">Monitor and manage your energy consumption efficiently</p>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full max-w-md lg:w-1/2 p-6">
                <div class="card bg-white rounded-3xl p-8 md:p-10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back!</h2>    
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <form action="{{ route('login.post') }}" method="POST" class="login-form">
                        @csrf
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" placeholder="your@email.com" required
                                    class="form-input w-full py-3 pl-10 pr-4 text-gray-700 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none @error('email') border-red-500 @enderror">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                            </div>
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
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                        </div>

                        <!-- Error message container -->
                        <div id="error-message" class="mb-4 text-center"></div>

                        <button type="submit" class="login-btn btn-primary w-full py-3 px-4 rounded-lg text-white font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mb-6">
                            Sign In
                        </button>
                    </form>

                    <p class="text-center text-gray-600 text-sm">
                        Don't have an account? <a href="{{ url('/register') }}" class="text-blue-600 font-medium hover:text-blue-800">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
    
            if (togglePassword) {
                togglePassword.addEventListener('click', function () {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });

        const emailInput = document.getElementById('email');
        const userEmail = emailInput.value;

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            
            loginForm.addEventListener('submit', function(e) {
                // Let the form submit normally
                // The controller will handle the response
            });
        });
    </script>
</body>

</html>