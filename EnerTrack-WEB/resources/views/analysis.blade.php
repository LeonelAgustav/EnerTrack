<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis</title>
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
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <main class="p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Energy Analysis</h1>
                <p class="text-gray-600">View your energy consumption patterns</p>
            </div>
            
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="card bg-white rounded-2xl p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">Energy Consumption Trends</h3>
                </div>
                <canvas id="trendChart" class="w-full h-80"></canvas>
            </div>
            <div class="card bg-white rounded-2xl p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Consumption by Category</h3>
                <div class="flex justify-center">
                    <canvas id="categoryChart" class="w-64 h-64"></canvas>
                </div>
                <div id="categoryLegend" class="mt-4 space-y-3">
                    <!-- Legend will be populated by JS -->
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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize Charts
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Konsumsi Energi (kWh)',
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(0, 98, 255, 0.79)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true // Ubah menjadi true
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
        let categoryChart;
        // Fetch category counts from backend
        fetch('/analysis/category-counts')
            .then(response => response.json())
            .then(result => {
                if (result.success && Array.isArray(result.data)) {
                    const data = result.data;
                    const total = data.reduce((sum, item) => sum + item.count, 0);
                    const labels = data.map(item => item.category);
                    const counts = data.map(item => item.count);
                    const colors = [
                        '#3b82f6', '#22c55e', '#a21caf', '#eab308', '#ef4444',
                        '#6366f1', '#f59e42', '#10b981', '#f472b6', '#f87171'
                    ];
                    // Destroy previous chart if exists
                    if (categoryChart) categoryChart.destroy();
                    categoryChart = new Chart(categoryCtx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: counts,
                                backgroundColor: colors.slice(0, labels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                    // Build legend
                    const legendDiv = document.getElementById('categoryLegend');
                    legendDiv.innerHTML = '';
                    data.forEach((item, idx) => {
                        const percent = total > 0 ? ((item.count / total) * 100).toFixed(1) : 0;
                        legendDiv.innerHTML += `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3" style="background:${colors[idx % colors.length]};border-radius:9999px;margin-right:8px;"></div>
                                    <span class="text-sm">${item.category}</span>
                                </div>
                                <span class="text-sm font-medium">${percent}%</span>
                            </div>
                        `;
                    });
                }
            });

        const weeklyCostCtx = document.getElementById('savingsChart').getContext('2d');
        const weeklyCostChart = new Chart(weeklyCostCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Biaya Mingguan (Rp)',
                    data: [],
                    backgroundColor: 'rgb(0, 200, 83)',
                    borderColor: 'rgb(0, 150, 50)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const weekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        async function fetchDailyStatistics() {
            try {
                const response = await fetch('/analysis/daily-statistics', {
                    headers: { 'Accept': 'application/json' }
                });
                const result = await response.json();
                if (result.success && result.data) {
                    updateTrendChart(result.data);
                } else {
                    console.error('Gagal mengambil data statistik harian:', result.message);
                }
            } catch (e) {
                console.error('Error fetching daily statistics:', e);
            }
        }

        function updateTrendChart(data) {
            const dataMap = {};
            data.forEach(item => {
                dataMap[item.date] = item.consumption;
            });
            const consumptions = weekDays.map(day => dataMap[day] || 0);

            trendChart.data.labels = weekDays;
            trendChart.data.datasets[0].data = consumptions;
            trendChart.update();
        }

        async function fetchWeeklyCost() {
            const response = await fetch('/analysis/weekly-cost-statistics', {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            // Tambahkan log untuk debug
            console.log("Weekly cost result:", result);
            if (result.success && result.data) {
                updateWeeklyCostChart(result.data);
            } else {
                updateWeeklyCostChart([]); // Kosongkan chart jika gagal
                console.error('Gagal mengambil data biaya mingguan:', result.message);
            }
        }

        function updateWeeklyCostChart(data) {
            const weekLabels = data.map((item, idx) => `Week ${idx + 1}`);
            weeklyCostChart.data.labels = weekLabels;
            weeklyCostChart.data.datasets[0].data = data.map(item => item.cost);
            weeklyCostChart.update();
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchDailyStatistics();
            fetchWeeklyCost();
        });
    </script>
</body>
</html>