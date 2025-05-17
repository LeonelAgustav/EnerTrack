<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Calculator</title>
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
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

        /* AI Analysis styles */
        .ai-analysis-item {
            transition: all 0.3s ease;
        }
        .ai-analysis-item:hover {
            transform: translateY(-3px);
        }
        .ai-tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .ai-tag.efficiency {
            background-color: #d1fae5;
            color: #065f46;
        }
        .ai-tag.cost {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .ai-tag.environment {
            background-color: #fef3c7;
            color: #92400e;
        }
        .ai-tag.health {
            background-color: #fce7f3;
            color: #9d174d;
        }
        .ai-tag.alert {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .ai-progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        .ai-progress-fill {
            height: 100%;
            border-radius: 4px;
        }
        .ai-progress-fill.high {
            background-color: #ef4444;
        }
        .ai-progress-fill.medium {
            background-color: #f59e0b;
        }
        .ai-progress-fill.low {
            background-color: #10b981;
        }
        .ai-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 6px;
            margin-bottom: 6px;
        }
        .ai-chip i {
            margin-right: 4px;
            font-size: 10px;
        }
        .ai-chip.efficiency {
            background-color: #d1fae5;
            color: #065f46;
        }
        .ai-chip.cost {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .ai-chip.environment {
            background-color: #fef3c7;
            color: #92400e;
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
                    <a href="{{ url('/calculator') }}" id="calculateTab" class="sidebar-item flex items-center space-x-3 bg-white/20 px-4 py-3 rounded-lg cursor-pointer">
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
                    <h1 class="text-3xl font-bold text-gray-800">Energy Calculator</h1>
                    <p class="text-gray-600">Calculate your appliance energy consumption</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calculator Form -->
                <div class="card bg-white rounded-2xl p-6 lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Energy Calculator</h2>
                    <form id="energyCalculatorForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="applianceBrand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <input type="text" id="applianceBrand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Samsung">
                            </div>
                            <div>
                                <label for="applianceName" class="block text-sm font-medium text-gray-700 mb-1">Appliance Name</label>
                                <input type="text" id="applianceName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Smart TV">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="applianceCategory" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="applianceCategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select a category</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Cooling">Cooling</option>
                                    <option value="Heating">Heating</option>
                                    <option value="Lighting">Lighting</option>
                                    <option value="Kitchen">Kitchen</option>
                                    <option value="Health">Health</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="powerRating" class="block text-sm font-medium text-gray-700 mb-1">Power Rating (Watt)</label>
                                <input type="number" id="powerRating" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 120">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dailyUsage" class="block text-sm font-medium text-gray-700 mb-1">Daily Usage (Hours)</label>
                                <input type="number" id="dailyUsage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 5">
                            </div>
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" id="quantity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="1" min="1">
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="button" id="calculateBtn" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Calculate Energy Consumption
                            </button>
                        </div>
                    </form>
                    <!-- Results Section -->
                    <div id="calculationResults" class="mt-8 hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Calculation Results</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-600 mb-1">Daily Consumption</p>
                                <p id="dailyResult" class="text-xl font-bold text-blue-800">0 kWh</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600 mb-1">Monthly Consumption</p>
                                <p id="monthlyResult" class="text-xl font-bold text-green-800">0 kWh</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-600 mb-1">Monthly Cost</p>
                                <p id="costResult" class="text-xl font-bold text-purple-800">$0</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="saveCalculationBtn" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors mr-3">
                                Save Calculation
                            </button>
                            <button type="button" id="resetCalculatorBtn" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
                <!-- AI Analysis Panel -->
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">AI Analysis</h2>
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-brain text-blue-600"></i>
                        </div>
                    </div>
                    <div id="aiAnalysisPlaceholder" class="text-center py-8">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-robot text-blue-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Calculate energy consumption to get AI-powered insights and recommendations</p>
                    </div>
                    <div id="aiAnalysisContent" class="hidden">
                        <!-- Efficiency Analysis -->
                        <div class="ai-analysis-item bg-white border border-gray-100 rounded-xl p-4 mb-4 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-800">Efficiency Rating</h3>
                                <span class="ai-tag efficiency">Efficiency</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3" id="efficiencyText">This appliance has a moderate energy efficiency rating compared to similar devices in its category.</p>
                            <div class="ai-progress-bar mb-2">
                                <div id="efficiencyProgress" class="ai-progress-fill medium" style="width: 60%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Low</span>
                                <span>Medium</span>
                                <span>High</span>
                            </div>
                        </div>
                        <!-- Cost Analysis -->
                        <div class="ai-analysis-item bg-white border border-gray-100 rounded-xl p-4 mb-4 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-800">Cost Impact</h3>
                                <span class="ai-tag cost">Cost</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3" id="costAnalysisText">This appliance contributes approximately 12% to your monthly electricity bill.</p>
                            <div class="flex flex-wrap mb-2">
                                <span class="ai-chip cost">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Monthly: $15.60
                                </span>
                                <span class="ai-chip cost">
                                    <i class="fas fa-calendar-alt"></i>
                                    Yearly: $187.20
                                </span>
                            </div>
                        </div>
                        <!-- Environmental Impact -->
                        <div class="ai-analysis-item bg-white border border-gray-100 rounded-xl p-4 mb-4 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-800">Environmental Impact</h3>
                                <span class="ai-tag environment">Eco</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3" id="environmentText">This appliance produces an estimated 24 kg of CO2 emissions monthly.</p>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-leaf text-yellow-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium">Carbon Footprint</span>
                                        <span class="font-medium">24 kg/mo</span>
                                    </div>
                                    <div class="ai-progress-bar">
                                        <div id="environmentProgress" class="ai-progress-fill high" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Recommendations -->
                        <div class="ai-analysis-item bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-semibold text-gray-800">Recommendations</h3>
                                <span class="ai-tag health">Tips</span>
                            </div>
                            <ul class="space-y-2 text-sm text-gray-600" id="recommendationsList">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    Consider using a smart power strip to reduce standby power consumption
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    Replace with an ENERGY STAR certified model for 30% more efficiency
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    Reduce usage by 1 hour daily to save ~$45 annually
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('calculateBtn').addEventListener('click', function() {
            const power = parseFloat(document.getElementById('powerRating').value) || 0;
            const usage = parseFloat(document.getElementById('dailyUsage').value) || 0;
            const quantity = parseFloat(document.getElementById('quantity').value) || 1;
            const rate = parseFloat(document.getElementById('electricityRate').value) || 0.15;
            
            // Calculate results
            const dailyKwh = (power * usage * quantity) / 1000;
            const monthlyKwh = dailyKwh * 30;
            const monthlyCost = monthlyKwh * rate;
            
            // Display results
            document.getElementById('dailyResult').textContent = dailyKwh.toFixed(3) + ' kWh';
            document.getElementById('monthlyResult').textContent = monthlyKwh.toFixed(1) + ' kWh';
            document.getElementById('costResult').textContent = '$' + monthlyCost.toFixed(2);
            
            // Show results section
            document.getElementById('calculationResults').classList.remove('hidden');
            
            // Generate AI Analysis
            generateAiAnalysis(power, usage, quantity, rate);
        });
        
        document.getElementById('resetCalculatorBtn').addEventListener('click', function() {
            document.getElementById('energyCalculatorForm').reset();
            document.getElementById('calculationResults').classList.add('hidden');
            document.getElementById('aiAnalysisContent').classList.add('hidden');
            document.getElementById('aiAnalysisPlaceholder').classList.remove('hidden');
        });
        
        function generateAiAnalysis(power, usage, quantity, rate) {
            // Hide placeholder and show analysis
            document.getElementById('aiAnalysisPlaceholder').classList.add('hidden');
            document.getElementById('aiAnalysisContent').classList.remove('hidden');
            
            // Calculate efficiency score (0-100)
            const efficiencyScore = Math.min(100, Math.max(0, 80 - (power / 10) + (Math.random() * 20)));
            
            // Set efficiency progress and text
            const efficiencyProgress = document.getElementById('efficiencyProgress');
            let efficiencyText = '';
            
            if (efficiencyScore > 70) {
                efficiencyProgress.className = 'ai-progress-fill low';
                efficiencyProgress.style.width = '90%';
                efficiencyText = 'This appliance has excellent energy efficiency compared to similar devices in its category.';
            } else if (efficiencyScore > 40) {
                efficiencyProgress.className = 'ai-progress-fill medium';
                efficiencyProgress.style.width = '60%';
                efficiencyText = 'This appliance has moderate energy efficiency. Consider more efficient alternatives for better savings.';
            } else {
                efficiencyProgress.className = 'ai-progress-fill high';
                efficiencyProgress.style.width = '30%';
                efficiencyText = 'This appliance has poor energy efficiency. We strongly recommend upgrading to a more efficient model.';
            }
            
            document.getElementById('efficiencyText').textContent = efficiencyText;
            
            // Calculate cost impact
            const dailyCost = (power * usage * quantity * rate) / 1000;
            const yearlyCost = dailyCost * 365;
            const monthlyKwh = (power * usage * quantity * 30) / 1000;
            
            // Update cost analysis
            const costPercentage = Math.min(30, Math.round((monthlyKwh / 320) * 100)); // Assuming 320kWh monthly total
            document.getElementById('costAnalysisText').textContent = 
                `This appliance contributes approximately ${costPercentage}% to your monthly electricity bill.`;
            
            // Update cost chips
            const costChips = document.querySelectorAll('.ai-chip.cost');
            costChips[0].innerHTML = `<i class="fas fa-money-bill-wave"></i> Monthly: $${(dailyCost * 30).toFixed(2)}`;
            costChips[1].innerHTML = `<i class="fas fa-calendar-alt"></i> Yearly: $${yearlyCost.toFixed(2)}`;
            
            // Calculate environmental impact
            const co2PerMonth = monthlyKwh * 0.85; // Assuming 0.85kg CO2 per kWh
            document.getElementById('environmentText').textContent = 
                `This appliance produces an estimated ${co2PerMonth.toFixed(1)} kg of CO2 emissions monthly.`;
            
            const envProgress = document.getElementById('environmentProgress');
            if (co2PerMonth > 20) {
                envProgress.className = 'ai-progress-fill high';
                envProgress.style.width = '80%';
            } else if (co2PerMonth > 10) {
                envProgress.className = 'ai-progress-fill medium';
                envProgress.style.width = '50%';
            } else {
                envProgress.className = 'ai-progress-fill low';
                envProgress.style.width = '20%';
            }
            
            // Generate recommendations based on appliance type and usage
            const category = document.getElementById('applianceCategory').value;
            const recommendationsList = document.getElementById('recommendationsList');
            recommendationsList.innerHTML = '';
            
            // Common recommendations
            const commonRecs = [
                `Consider using a smart power strip to reduce standby power consumption`,
                `Reduce usage by 1 hour daily to save ~$${(dailyCost * 365 * 0.8).toFixed(0)} annually`
            ];
            
            // Category-specific recommendations
            let categoryRecs = [];
            if (category === 'Entertainment') {
                categoryRecs = [
                    `Enable power saving mode to reduce energy use by up to 30%`,
                    `Lower brightness settings to save energy without sacrificing quality`
                ];
            } else if (category === 'Cooling') {
                categoryRecs = [
                    `Set temperature 1°C higher to save ~5% on cooling costs`,
                    `Clean filters monthly for optimal efficiency`
                ];
            } else if (category === 'Lighting') {
                categoryRecs = [
                    `Replace with LED bulbs for 75% more efficiency`,
                    `Use motion sensors in low-traffic areas`
                ];
            } else if (category === 'Kitchen') {
                categoryRecs = [
                    `Use smaller appliances for small tasks (toaster oven vs full oven)`,
                    `Preheat only when necessary and for minimum time`
                ];
            } else {
                categoryRecs = [
                    `Unplug when not in use to avoid phantom load`,
                    `Consider ENERGY STAR certified alternatives`
                ];
            }
            
            // Combine and display recommendations
            [...categoryRecs, ...commonRecs].slice(0, 3).forEach(rec => {
                const li = document.createElement('li');
                li.className = 'flex items-start';
                li.innerHTML = `<i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i> ${rec}`;
                recommendationsList.appendChild(li);
            });
        }
    </script>
</body>
</html>