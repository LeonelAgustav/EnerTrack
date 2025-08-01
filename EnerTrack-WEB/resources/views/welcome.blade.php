<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnerTrack - Control Your Home's Energy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .bolt-icon {
            animation: pulse 2s infinite;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.7);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Hero Section -->
        <section class="hero-bg py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center fade-in">
                <div class="flex justify-center mb-6">
                    <div class="bolt-icon rounded-full p-4">
                        <i class="fas fa-bolt text-white text-4xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Welcome to EnerTrack!</h1>
                <p class="text-xl md:text-2xl text-blue-600 font-semibold mb-8">Take Control of Your Home's Energy</p>
                
                <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                    EnerTrack monitors and analyzes your household electricity consumption in real-time, giving you clear insights instead of estimates. No more guessing about your energy use—just smart data to help you save.
                </p>
                
                <button onclick="scrollToFeatures()" class="px-8 py-3 bg-blue-600 text-white font-medium rounded-full hover:bg-blue-700 transition duration-300 shadow-lg hover:shadow-xl">
                    Learn How It Works
                </button>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">How EnerTrack Helps You</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="text-blue-500 text-3xl mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">See Your Usage Clearly</h3>
                        <p class="text-gray-600">Real-time dashboard shows exactly how and when you use electricity.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="text-blue-500 text-3xl mb-4">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Identify Energy Hogs</h3>
                        <p class="text-gray-600">Discover which appliances are costing you the most money.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="text-blue-500 text-3xl mb-4">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Save Money</h3>
                        <p class="text-gray-600">Reduce your bill by adjusting usage based on our recommendations.</p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="feature-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="text-blue-500 text-3xl mb-4">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Track Your Progress</h3>
                        <p class="text-gray-600">Set goals and see your energy savings grow over time.</p>
                    </div>
                </div>
                
                <div class="mt-16 text-center">
                    <p class="text-2xl font-light text-gray-700 mb-8 italic">
                        "EnerTrack: Smart Insights, Simpler Savings."
                    </p>
                    
                    <div class="max-w-md mx-auto bg-blue-100 rounded-2xl p-8 shadow-inner">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Ready to start saving?</h3>
                        <a href="{{ url('/login') }}" class="px-8 py-3 bg-blue-600 text-white font-medium rounded-full hover:bg-blue-700 transition duration-300">
                            Get Started Today
                        </a>
                        <p class="text-sm text-gray-600 mt-3">No commitment, just clearer energy insights.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-800 text-white">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center">
                            <i class="fas fa-bolt text-yellow-400 text-2xl mr-2"></i>
                            <span class="text-xl font-semibold">EnerTrack</span>
                        </div>
                        <p class="text-gray-400 mt-2">Empowering smarter energy decisions.</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="https://github.com/LeonelAgustav/EnerTrack" class="text-gray-300 hover:text-white transition" target="_blank">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400 text-sm">
                    &copy; 2025 EnerTrack. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        function scrollToFeatures() {
            document.getElementById('features').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }
    </script>
</body>
</html>