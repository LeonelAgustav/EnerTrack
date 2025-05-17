<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculation History</title>
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
        /* Modal styles */
        .modal {
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }
        .modal.active .modal-content {
            transform: translateY(0);
        }
        /* Custom scrollbar */
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
        /* Tab styles */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .tab-button {
            position: relative;
            padding-bottom: 8px;
        }
        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #3b82f6;
            border-radius: 3px;
        }
        /* Timeline styles */
        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #3b82f6;
            z-index: 1;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 11px;
            top: 12px;
            width: 2px;
            height: calc(100% - 12px);
            background-color: #e5e7eb;
        }
        .timeline-item:last-child::after {
            display: none;
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
                    <a href="{{ url('/dashboard') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-home text-lg"></i>
                        <span class="font-medium">Home</span>
                    </a>
                    <a href="{{ url('/calculator') }}" class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
                        <i class="fas fa-calculator text-lg"></i>
                        <span class="font-medium">Calculate</span>
                    </a>
                    <a href="{{ url('/history') }}" id="historyTab" class="sidebar-item flex items-center space-x-3 bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
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
                    <h1 class="text-3xl font-bold text-gray-800">Calculation History</h1>
                    <p class="text-gray-600">View your past calculations</p>
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

            <!-- Calculation History Table -->
            <div class="card bg-white rounded-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Calculation History</h2>
                    <div class="flex space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>All Categories</option>
                            <option>Entertainment</option>
                            <option>Cooling</option>
                            <option>Lighting</option>
                            <option>Kitchen</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Appliance</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Power (W)</th>
                                <th class="px-6 py-3">Usage (Hrs)</th>
                                <th class="px-6 py-3">Daily (kWh)</th>
                                <th class="px-6 py-3">Monthly (kWh)</th>
                                <th class="px-6 py-3">Cost</th>
                                <th class="px-12 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="historyRow" class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">2023-06-15</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">Samsung Smart TV</div>
                                    <div class="text-xs text-gray-500">55" QLED</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Entertainment</span>
                                </td>
                                <td class="px-6 py-4">120</td>
                                <td class="px-6 py-4">5</td>
                                <td class="px-6 py-4">0.6</td>
                                <td class="px-6 py-4">18.0</td>
                                <td class="px-6 py-4 font-medium">$2.70</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-recycle"></i>
                                            <span>Optimize</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">2023-06-14</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">LG AC Inverter</div>
                                    <div class="text-xs text-gray-500">1.5 HP</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Cooling</span>
                                </td>
                                <td class="px-6 py-4">800</td>
                                <td class="px-6 py-4">8</td>
                                <td class="px-6 py-4">6.4</td>
                                <td class="px-6 py-4">192.0</td>
                                <td class="px-6 py-4 font-medium">$28.80</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-recycle"></i>
                                            <span>Optimize</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">2023-06-13</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">Xiaomi Air Purifier</div>
                                    <div class="text-xs text-gray-500">Model 3H</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Health</span>
                                </td>
                                <td class="px-6 py-4">45</td>
                                <td class="px-6 py-4">24</td>
                                <td class="px-6 py-4">1.08</td>
                                <td class="px-6 py-4">32.4</td>
                                <td class="px-6 py-4 font-medium">$4.86</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-recycle"></i>
                                            <span>Optimize</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">2023-06-12</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">Philips LED Bulb</div>
                                    <div class="text-xs text-gray-500">9W Warm White</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Lighting</span>
                                </td>
                                <td class="px-6 py-4">9</td>
                                <td class="px-6 py-4">12</td>
                                <td class="px-6 py-4">0.108</td>
                                <td class="px-6 py-4">3.24</td>
                                <td class="px-6 py-4 font-medium">$0.49</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-recycle"></i>
                                            <span>Optimize</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-row border-b hover:bg-gray-50">
                                <td class="px-6 py-4">2023-06-11</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">Panasonic Microwave</div>
                                    <div class="text-xs text-gray-500">20L</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Kitchen</span>
                                </td>
                                <td class="px-6 py-4">1000</td>
                                <td class="px-6 py-4">0.5</td>
                                <td class="px-6 py-4">0.5</td>
                                <td class="px-6 py-4">15.0</td>
                                <td class="px-6 py-4 font-medium">$2.25</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center space-x-2">
                                            <i class="fas fa-recycle"></i>
                                            <span>Optimize</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">12</span> entries
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Previous
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-100">
                            2
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-100">
                            3
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-100">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    </script>
</body>
</html>