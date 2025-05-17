<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Analytics</title>
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
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
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

        /* Chart-specific styles */
        .chart-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .chart-card:hover {
            transform: translateY(-5px);
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .chart-header select {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            font-size: 0.875rem;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 9999px;
            margin-right: 8px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-cyan-500 to-blue-600 text-white p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-8 h-8 bg-white ro unded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-blue-600"></i>
                    </div>
                    <span class="text-2xl font-bold">EnerTrack</span>
                </div>
                <nav class="space-y-3">
                    <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
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
                    <a href="{{ url('/analysis') }}" id="analyticsTab" class="sidebar-item flex items-center space-x-3 bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
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
                    <h1 class="text-3xl font-bold text-gray-800">Energy Analytics</h1>
                    <p class="text-gray-600">Detailed insights about your consumption</p>
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

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="card bg-white rounded-2xl p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-800">Energy Consumption Trends</h3>
                        <select class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                            <option>Last 6 Months</option>
                            <option>This Year</option>
                        </select>
                    </div>
                    <canvas id="trendChart" class="w-full h-80"></canvas>
                </div>
                <div class="card bg-white rounded-2xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Consumption by Category</h3>
                    <div class="flex justify-center">
                        <canvas id="categoryChart" class="w-64 h-64"></canvas>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-sm">Entertainment</span>
                            </div>
                            <span class="text-sm font-medium">32%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm">Cooling</span>
                            </div>
                            <span class="text-sm font-medium">27%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-sm">Lighting</span>
                            </div>
                            <span class="text-sm font-medium">18%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-sm">Kitchen</span>
                            </div>
                            <span class="text-sm font-medium">15%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-sm">Other</span>
                            </div>
                            <span class="text-sm font-medium">8%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="card bg-white rounded-2xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Cost Savings Over Time</h3>
                    <canvas id="savingsChart" class="w-full h-64"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize Charts
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Energy Consumption (kWh)',
                    data: [120, 150, 130, 180, 160, 200],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
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
                        beginAtZero: true
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Entertainment', 'Cooling', 'Lighting', 'Kitchen', 'Other'],
                datasets: [{
                    data: [32, 27, 18, 15, 8],
                    backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const savingsCtx = document.getElementById('savingsChart').getContext('2d');
        new Chart(savingsCtx, {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{
                    label: 'Savings ($)',
                    data: [120, 150, 130, 180],
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>