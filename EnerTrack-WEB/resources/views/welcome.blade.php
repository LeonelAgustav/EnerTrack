<!DOCTYPE html>
<html lang='id'>

<head>

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>Energy Calculator</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
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
                    <a class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer" href="{{ url('/dashboard') }}">
                        <i class="fas fa-home text-lg"></i>
                        <span class="font-medium">Home</span>
                    </a>
                    <a class="sidebar-item flex items-center space-x-3 bg-white/20 px-4 py-3 rounded-lg cursor-pointer" href="{{ url('/calculator') }}" id="calculateTab">
                        <i class="fas fa-calculator text-lg"></i>
                        <span class="font-medium">Calculate</span>
                    </a>
                    <a class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer" href="{{ url('/history') }}">
                        <i class="fas fa-history text-lg"></i>
                        <span class="font-medium">History</span>
                    </a>
                    <a class="sidebar-item flex items-center space-x-3 hover:bg-white/20 px-4 py-3 rounded-lg cursor-pointer" href="{{ url('/analysis') }}">
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
                
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calculator Form -->
                <div class="card bg-white rounded-2xl p-6 lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Energy Calculator</h2>
                    <form class="space-y-4" id="energyCalculatorForm">
                    <div class="card bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Jenis Pembayaran Listrik</h2>
                        <select id="billingType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" onchange="toggleElectricityInput()">
                            <option value="">Pilih jenis pembayaran</option>
                            <option value="token">Token Listrik</option>
                            <option value="pascabayar">Pascabayar</option>
                        </select>
                    </div>  
                    <div id="tokenInput" class="card bg-white p-6 rounded-lg shadow-md mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Input Token Listrik</h2>
                        <input type="number" id="tokenAmount" class="w-full px-4 py-2 mb-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Jumlah Token (Rp)">
                        <input type="number" id="tokenKwh" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Jumlah Token (kWh)">
                    </div>

                    <div id="pascabayarInput" class="card bg-white p-6 rounded-lg shadow-md mb-6" style="display: none;">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Input Pascabayar</h2>
                        <input type="number" id="pascabayarVA" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Konsumsi Listrik Bulanan (VA)">
                    </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="deviceBrand" class="block text-gray-700 font-medium mb-1">Brand</label>
                            <select id="deviceBrand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Select a Brand...</option>
                            </select>
                        </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="applianceName">Appliance Name</label>
                                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="applianceName" placeholder="e.g. Smart TV" type="text" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="applianceCategory">Category</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="applianceCategory">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="powerRating">Power Rating (Watt)</label>
                                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="powerRating" placeholder="e.g. 120" type="number" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="dailyUsage">Daily Usage (Hours)</label>
                                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="dailyUsage" placeholder="e.g. 5" type="number" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="quantity">Quantity</label>
                                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="quantity" min="1" type="number" value="1" />
                            </div>
                        </div>
                        <div class="pt-4">
                            <button onclick="submitAndAnalyze()" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors" id="calculateBtn" type="button">
                                Calculate Energy Consumption
                            </button>
                        </div>
                    </form>
                </div>
                <!-- AI Analysis Panel -->
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">AI Analysis</h2>
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-brain text-blue-600"></i>
                        </div>
                    </div>
                    <div id="analysisCards" class="grid grid-cols-1 md:grid-cols-[minmax(250px,auto)_1fr] gap-6 mt-4">
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Device Modal -->
    <div id="editDeviceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Perangkat</h2>
            <form id="editDeviceForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merek</label>
                    <select id="editDeviceBrand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Merek...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perangkat</label>
                    <input type="text" id="editDeviceName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daya (Watt)</label>
                    <input type="number" id="editDevicePower" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (Jam/Hari)</label>
                    <input type="number" id="editDeviceDuration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" max="24" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="button" onclick="updateDevice()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let devices = [];
        let editIndex = -1;

        // Load brands when page loads
        window.addEventListener('DOMContentLoaded', function() {
            loadBrands();
            toggleElectricityInput();
        });

        // Load brands from server with retry mechanism
        async function loadBrands(retryCount = 0) {
            const maxRetries = 3;
            const retryDelay = 1000; // 1 second

            try {
                const response = await fetch("http://localhost:8081/api/brands", {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const brands = await response.json();
                
                if (!Array.isArray(brands) || brands.length === 0) {
                    console.warn("No brands received from server");
                    return;
                }

                const brandSelects = document.querySelectorAll("#deviceBrand, #editDeviceBrand");

                brandSelects.forEach(select => {
                    select.innerHTML = '<option value="">Select a Brand...</option>';
                    brands.forEach(brand => {
                        const option = document.createElement("option");
                        option.value = brand;
                        option.textContent = brand;
                        select.appendChild(option);
                    });
                });

            } catch (error) {
                console.error("Error loading brands:", error);
                
                if (retryCount < maxRetries) {
                    console.log(`Retrying... Attempt ${retryCount + 1} of ${maxRetries}`);
                    setTimeout(() => loadBrands(retryCount + 1), retryDelay);
                } else {
                    const errorMessage = "Failed to load brands. Please check if the backend server is running at http://localhost:8081";
                    console.error(errorMessage);
                    
                    // Show error in UI
                    const brandSelects = document.querySelectorAll("#deviceBrand, #editDeviceBrand");
                    brandSelects.forEach(select => {
                        select.innerHTML = '<option value="">Error loading brands</option>';
                        select.disabled = true;
                    });

                    // Show error notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>${errorMessage}</span>
                        </div>
                    `;
                    document.body.appendChild(notification);
                    
                    // Remove notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }
            }
        }

        // Toggle electricity input based on billing type
        function toggleElectricityInput() {
            const billingType = document.getElementById("billingType").value;
            document.getElementById("tokenInput").style.display = billingType === "token" ? "block" : "none";
            document.getElementById("pascabayarInput").style.display = billingType === "pascabayar" ? "block" : "none";
        }

        // Calculate energy consumption
        document.getElementById('calculateBtn').addEventListener('click', function() {
            const power = parseFloat(document.getElementById('powerRating').value) || 0;
            const usage = parseFloat(document.getElementById('dailyUsage').value) || 0;
            const quantity = parseFloat(document.getElementById('quantity').value) || 1;
            const rate = 0.15; // Default rate, should be configurable

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
            analyzeData();
        });

        // Reset calculator
        document.getElementById('resetCalculatorBtn').addEventListener('click', function() {
            document.getElementById('energyCalculatorForm').reset();
            document.getElementById('calculationResults').classList.add('hidden');
            document.getElementById('aiAnalysisContent').classList.add('hidden');
            document.getElementById('aiAnalysisPlaceholder').classList.remove('hidden');
        });

        // Validate form
        function validateForm() {
            const billingType = document.getElementById("billingType").value;
            if (!billingType) {
                alert("Please select a billing type!");
                return false;
            }

            if (billingType === "token") {
                const tokenAmount = document.getElementById("tokenAmount").value;
                const tokenKwh = document.getElementById("tokenKwh").value;
                if (!tokenAmount || !tokenKwh) {
                    alert("Please fill in all token fields!");
                    return false;
                }
            } else if (billingType === "pascabayar") {
                const pascabayarVA = document.getElementById("pascabayarVA").value;
                if (!pascabayarVA) {
                    alert("Please fill in the VA field!");
                    return false;
                }
            }

            return true;
        }

        // Gabungan submit dan analisis
        async function submitAndAnalyze() {
            if (!validateForm()) return;

            const billingType = document.getElementById("billingType").value;
            const tokenAmount = parseFloat(document.getElementById("tokenAmount").value);
            const tokenKwh = parseFloat(document.getElementById("tokenKwh").value);
            const pascabayarVA = parseFloat(document.getElementById("pascabayarVA").value);

            // Add billing information to each device
            devices.forEach(device => {
                device.Jenis_Pembayaran = billingType;
                device.Besar_Listrik = billingType === "token" ? `${tokenKwh} kWh` : `${pascabayarVA} VA`;
            });

            const userData = {
                billingtype: billingType,
                electricity: {
                    amount: billingType === "token" ? tokenAmount : undefined,
                    kwh: billingType === "token" ? tokenKwh : pascabayarVA
                },
                devices: devices
            };

            let resultDiv = document.getElementById("analysisCards");
            resultDiv.innerHTML = "⏳ Sedang mengirim & menganalisis...";

            try {
                const response = await fetch("http://localhost:8081/api/devices/submit", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(userData)
                });

                if (!response.ok) throw new Error(`Failed to submit data: ${response.statusText}`);

                // Setelah submit sukses, lakukan analisis
                try {
                    let analyzeResponse = await fetch("http://localhost:8081/api/analyze");
                    if (!analyzeResponse.ok) throw new Error("Gagal mendapatkan analisis");
                    let data = await analyzeResponse.json();

                    resultDiv.innerHTML = `
                        <div class=\"grid grid-cols-1 md:grid-cols-2 gap-6\">
                            <!-- Ringkasan Penggunaan -->
                            <div class=\"bg-white p-6 rounded-lg shadow-md border border-gray-200\">
                                <h3 class=\"text-lg font-bold mb-4\">📊 Ringkasan Penggunaan</h3>
                                <hr class=\"border-t border-gray-200 my-4\">
                                <ul class=\"space-y-2 text-gray-700\">
                                    <li><strong>Total Harian:</strong> ${data.total_power_wh} Wh = ${(data.daily_kwh).toFixed(2)} kWh</li>
                                    <li><strong>Total Bulanan:</strong> ${(data.monthly_kwh).toFixed(2)} kWh</li>
                                    <li><strong>Golongan Tarif:</strong> ${data.besar_listrik}</li>
                                    <li><strong>Tarif Listrik:</strong> Rp ${data.tariff_rate.toLocaleString()}</li>
                                    <li><strong>Estimasi Biaya Bulanan:</strong> ${data.estimated_monthly_rp}</li>
                                </ul>
                            </div>
    
                            <!-- Analisis AI -->
                            <div class=\"bg-white p-6 rounded-lg shadow-md border border-gray-200\">
                                <h3 class=\"text-lg font-bold mb-2\">💡 Saran Penghematan</h3>
                                <hr class=\"border-t border-gray-200 my-4\">
                                <ul class=\"list-disc pl-5 space-y-1 text-gray-700 whitespace-pre-line\">
                                    ${data.ai_response.split('\n').filter(Boolean).map(item => `<li>${item.trim()}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    `;
                } catch (error) {
                    resultDiv.innerHTML = "<p class='text-red-500'>❌ Gagal mendapatkan analisis!</p>";
                    console.error("Analysis error:", error);
                }

                alert("✅ Data submitted & analyzed successfully!");
            } catch (error) {
                resultDiv.innerHTML = "<p class='text-red-500'>❌ Gagal submit data!</p>";
                console.error("Submit error:", error);
                alert("❌ Error: " + error.message);
            }
        }

        // Edit device functions
        function openEditModal(index) {
            editIndex = index;
            const device = devices[index];
            
            document.getElementById("editDeviceBrand").value = device.brand;
            document.getElementById("editDeviceName").value = device.name;
            document.getElementById("editDevicePower").value = device.power;
            document.getElementById("editDeviceDuration").value = device.duration;

            document.getElementById("editDeviceModal").style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function closeEditModal() {
            document.getElementById("editDeviceModal").style.display = "none";
            document.body.style.overflow = "auto";
        }

        function updateDevice() {
            if (editIndex === -1) return;

            const device = devices[editIndex];
            const duration = parseInt(document.getElementById("editDeviceDuration").value, 10);

            if (duration < 1 || duration > 24) {
                alert("Duration must be between 1 and 24 hours!");
                return;
            }

            device.brand = document.getElementById("editDeviceBrand").value;
            device.name = document.getElementById("editDeviceName").value;
            device.power = parseInt(document.getElementById("editDevicePower").value, 10);
            device.duration = duration;

            updateDeviceList();
            closeEditModal();
        }

        // Update device list display
        function updateDeviceList() {
            const deviceListContainer = document.getElementById('deviceList');
            if (!deviceListContainer) return;

            deviceListContainer.innerHTML = '';
            
            if (devices.length === 0) {
                deviceListContainer.innerHTML = '<p class="text-gray-500 text-center py-4">No devices added yet</p>';
                return;
            }

            const table = document.createElement('table');
            table.classList.add('min-w-full', 'bg-white', 'border-collapse', 'shadow-md', 'rounded-lg');

            // Add table headers
            const headers = ['Brand', 'Device Name', 'Power (Watt)', 'Duration (Hours/Day)', 'Actions'];
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            
            headers.forEach(header => {
                const th = document.createElement('th');
                th.classList.add('px-6', 'py-3', 'text-left', 'text-sm', 'font-medium', 'text-gray-700', 'border', 'border-gray-200', 'bg-gray-50');
                th.textContent = header;
                headerRow.appendChild(th);
            });
            
            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Add table body
            const tbody = document.createElement('tbody');
            
            devices.forEach((device, index) => {
                const row = document.createElement('tr');
                row.classList.add('border-b', 'border-gray-200', 'hover:bg-gray-50');

                // Add device data cells
                [device.brand, device.name, `${device.power}W`, `${device.duration} hours/day`].forEach(text => {
                    const td = document.createElement('td');
                    td.classList.add('px-6', 'py-4', 'text-sm', 'text-gray-700', 'border', 'border-gray-200');
                    td.textContent = text;
                    row.appendChild(td);
                });

                // Add action buttons
                const actionCell = document.createElement('td');
                actionCell.classList.add('px-6', 'py-4', 'text-sm', 'border', 'border-gray-200');

                const editButton = document.createElement('button');
                editButton.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600', 'font-semibold', 'px-4', 'py-2', 'rounded-md', 'focus:outline-none', 'mr-2');
                editButton.textContent = 'Edit';
                editButton.onclick = () => openEditModal(index);

                const removeButton = document.createElement('button');
                removeButton.classList.add('bg-red-500', 'text-white', 'hover:bg-red-600', 'font-semibold', 'px-4', 'py-2', 'rounded-md', 'focus:outline-none');
                removeButton.textContent = 'Remove';
                removeButton.onclick = () => {
                    devices.splice(index, 1);
                    updateDeviceList();
                };

                actionCell.appendChild(editButton);
                actionCell.appendChild(removeButton);
                row.appendChild(actionCell);

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            deviceListContainer.appendChild(table);
        }
    </script>
</body>

</html>