<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }

        .sidebar-item:hover {
            transform: translateX(5px);
        }

        .card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-cyan-500 to-blue-600 text-white p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-blue-600"></i>
                    </div>
                    <span class="text-2xl font-bold">EnerTrack</span>
                </div>
                <nav class="space-y-3">
                    <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-home text-lg"></i>
                        <span class="font-medium">Home</span>
                    </a>
                    <a href="{{ url('/calculator') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-calculator text-lg"></i>
                        <span class="font-medium">Calculate</span>
                    </a>
                    <a href="{{ url('/history') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-history text-lg"></i>
                        <span class="font-medium">History</span>
                    </a>
                    <a href="{{ url('/analysis') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-chart-line text-lg"></i>
                        <span class="font-medium">Analytics</span>
                    </a>
                </nav>
                <div class="mt-32">
                    <div class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-cog text-lg"></i>
                        <span class="font-medium">Settings</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-white/10 cursor-pointer hover:bg-white/20">
                <i class="fas fa-sign-out-alt"></i>
                <span class="font-medium">Logout</span>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-600">Monitor your energy consumption</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 text-xl cursor-pointer hover:text-blue-600"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white px-4 py-2 rounded-full shadow-sm cursor-pointer hover:shadow-md transition-shadow">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <span>AN</span>
                        </div>
                        <span class="font-semibold text-gray-700">Aspara Nagato</span>
                        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl p-6 mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Welcome back, Aspara!</h2>
                        <p class="opacity-90">Here's your weekly energy consumption overview</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500">Today's Usage</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-2">45 kWh</h3>
                            <p class="text-sm text-green-500 mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from yesterday
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-pie text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500">Weekly Usage</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-2">320 kWh</h3>
                            <p class="text-sm text-red-500 mt-1 flex items-center">
                                <i class="fas fa-arrow-down mr-1"></i> 8% from last week
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-week text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500">Monthly Cost</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-2">$128.50</h3>
                            <p class="text-sm text-green-500 mt-1 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 5% savings
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Energy Usage Chart -->
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-800">Energy Usage Report</h3>
                        <div class="flex space-x-2">
                            <button id="weekBtn" class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm hover:bg-blue-600">Week</button>
                            <button id="monthBtn" class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm hover:bg-blue-200">Month</button>
                        </div>
                    </div>
                    <canvas id="energyChart" class="w-full h-64"></canvas>
                </div>

                <!-- Top Appliances -->
                <div class="card bg-white rounded-2xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Top Energy Consumers</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-tv text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Smart TV</p>
                                    <p class="text-sm text-gray-500">Living Room</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-red-500">18 kWh</p>
                                <p class="text-xs text-gray-500">32% of total</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-thermometer-full text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">AC Unit</p>
                                    <p class="text-sm text-gray-500">Bedroom</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-orange-500">15 kWh</p>
                                <p class="text-xs text-gray-500">27% of total</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-desktop text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Gaming PC</p>
                                    <p class="text-sm text-gray-500">Study Room</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-blue-500">12 kWh</p>
                                <p class="text-xs text-gray-500">21% of total</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-lightbulb text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">LED Lights</p>
                                    <p class="text-sm text-gray-500">Whole House</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-green-500">8 kWh</p>
                                <p class="text-xs text-gray-500">14% of total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Calculations Table -->
            <div class="card bg-white rounded-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Calculations</h3>
                    <a href="{{ url('/calculator') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add New</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Brand</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Power (W)</th>
                                <th class="px-6 py-3">Usage (Hrs)</th>
                                <th class="px-6 py-3">Total (kWh)</th>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">Samsung</td>
                                <td class="px-6 py-4">Smart TV 55"</td>
                                <td class="px-6 py-4">Entertainment</td>
                                <td class="px-6 py-4">120</td>
                                <td class="px-6 py-4">5</td>
                                <td class="px-6 py-4 font-medium">0.6</td>
                                <td class="px-6 py-4">2023-06-15</td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-500 hover:text-blue-700 mr-3"><i class="fas fa-eye"></i></button>
                                    <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Charts Initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Button Selection Handler
            const weekBtn = document.getElementById('weekBtn');
            const monthBtn = document.getElementById('monthBtn');

            function selectButton(selectedBtn) {
                // Reset both buttons
                weekBtn.classList.remove('bg-blue-500', 'text-white');
                weekBtn.classList.add('bg-blue-100', 'text-blue-600');
                monthBtn.classList.remove('bg-blue-500', 'text-white');
                monthBtn.classList.add('bg-blue-100', 'text-blue-600');

                // Set selected button
                selectedBtn.classList.remove('bg-blue-100', 'text-blue-600');
                selectedBtn.classList.add('bg-blue-500', 'text-white');
            }

            weekBtn.addEventListener('click', () => selectButton(weekBtn));
            monthBtn.addEventListener('click', () => selectButton(monthBtn));

            // Energy Usage Chart
            const energyCtx = document.getElementById('energyChart').getContext('2d');
            const energyChart = new Chart(energyCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Energy Consumption (kWh)',
                        data: [12, 19, 15, 17, 14, 16, 18],
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>