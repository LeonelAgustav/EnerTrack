<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .nav-item {
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            transform: translateY(-2px);
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

        /* Category badge styles */
        .category-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .category-badge.entertainment {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .category-badge.cooling {
            background-color: #dcfce7;
            color: #166534;
        }
        .category-badge.lighting {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .category-badge.kitchen {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .category-badge.health {
            background-color: #f3e8ff;
            color: #6b21a8;
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
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <main class="p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-600">Monitor your energy consumption</p>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="card bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Welcome, <span id="username">Loading...</span>!</h2>
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
                        <h3 class="text-2xl font-bold text-gray-800 mt-2"><span id="todayUsage">Loading...</span> kWh</h3>
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
                        <h3 class="text-2xl font-bold text-gray-800 mt-2"><span id="weeklyUsage">Loading...</span> kWh</h3>
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
                        <h3 class="text-2xl font-bold text-gray-800 mt-2"><span id="monthlyCost">Loading...</span></h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Calculations Table -->
        <div class="card bg-white rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Recent Calculations</h3>
                <div class="flex space-x-2">
                    <a href="{{ url('/history') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 flex items-center space-x-2">
                        <i class="fas fa-eye"></i>
                        <span>View All</span>
                    </a>
                    <a href="{{ url('/calculator') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add New</span>
                    </a>
                </div>
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
                        </tr>
                    </thead>
                    <tbody id="recentCalculationsTable">
                        <tr class="table-row border-b hover:bg-gray-50">
                            <td colspan="7" class="px-6 py-4 text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch dashboard data
        async function fetchDashboardData() {
            try {
                const response = await fetch('/dashboard/recent-calculations', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'include'
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch dashboard data');
                }

                const data = await response.json();
                console.log('Dashboard data:', data);
                updateDashboard(data);
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
                showError('Failed to load dashboard data. Please try again later.');
            }
        }

        // Update dashboard with fetched data
        function updateDashboard(data) {
            // Update welcome message
            document.getElementById('username').textContent = data.username;

            // Update stats
            document.getElementById('todayUsage').textContent = data.today_usage.toFixed(2);
            document.getElementById('weeklyUsage').textContent = data.weekly_usage.toFixed(2);
            document.getElementById('monthlyCost').textContent = data.monthly_cost;

            // Update recent calculations table
            const tableBody = document.getElementById('recentCalculationsTable');
            tableBody.innerHTML = '';

            if (data.recent_calculations && data.recent_calculations.length > 0) {
                data.recent_calculations.forEach(calc => {
                    const row = document.createElement('tr');
                    row.className = 'table-row border-b hover:bg-gray-50';
                    row.innerHTML = `
                        <td class="px-6 py-4">${calc.brand}</td>
                        <td class="px-6 py-4">${calc.name}</td>
                        <td class="px-6 py-4">
                            <span class="category-badge ${calc.category.toLowerCase()}">${calc.category}</span>
                        </td>
                        <td class="px-6 py-4">${calc.power}</td>
                        <td class="px-6 py-4">${calc.usage_hours}</td>
                        <td class="px-6 py-4 font-medium">${calc.total_kwh.toFixed(2)}</td>
                        <td class="px-6 py-4">${calc.date}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = `
                    <tr class="table-row border-b hover:bg-gray-50">
                        <td colspan="7" class="px-6 py-4 text-center">No recent calculations found</td>
                    </tr>
                `;
            }
        }

        // Show error message
        function showError(message) {
            const tableBody = document.getElementById('recentCalculationsTable');
            tableBody.innerHTML = `
                <tr class="table-row border-b hover:bg-gray-50">
                    <td colspan="7" class="px-6 py-4 text-center text-red-500">${message}</td>
                </tr>
            `;
        }

        // Load dashboard data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchDashboardData();
        });
    </script>
</body>

</html>