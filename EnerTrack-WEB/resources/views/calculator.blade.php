<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Energy Calculator</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Responsive table styles */
        @media (max-width: 768px) {
            .responsive-table {
                display: block;
                width: 100%;
            }
            
            .responsive-table thead {
                display: none;
            }
            
            .responsive-table tbody {
                display: block;
                width: 100%;
            }
            
            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.5rem;
            }
            
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem;
                border: none;
                border-bottom: 1px solid #f3f4f6;
            }
            
            .responsive-table td:last-child {
                border-bottom: none;
            }
            
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
            }
        }

        /* Modal styles for mobile */
        @media (max-width: 640px) {
            .modal-content {
                width: 90%;
                margin: 1rem;
                padding: 1rem;
            }
        }

        #deviceList {
            max-height: 600px; /* atau sesuai kebutuhan */
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @include('layouts.sidebar')
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Energy Calculator</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Calculate your appliance energy consumption</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Calculator Form -->
                <div class="card bg-white rounded-2xl p-4 sm:p-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Energy Calculator</h2>
                        <form id="energyCalculatorForm">
                            <div class="card bg-white p-4 sm:p-6 rounded-lg shadow-md mb-4 sm:mb-6 space-y-4">
                                <div>
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Jenis Pembayaran Listrik</h2>
                                    <select id="billingType" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base" onchange="toggleElectricityInput()">
                                        <option value="">Pilih jenis pembayaran</option>
                                        <option value="token">Token Listrik</option>
                                        <option value="pascabayar">Pascabayar</option>
                                    </select>
                                </div>
                                <div id="tokenInput" class="space-y-4" style="display: none;">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Input Token Listrik</h2>
                                    <input type="number" id="tokenAmount" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base" placeholder="Jumlah Token (Rp)">
                                    <input type="number" id="tokenKwh" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base" placeholder="Jumlah Token (kWh)">
                                </div>
                                <div id="pascabayarInput" class="space-y-4" style="display: none;">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4">Input Pascabayar</h2>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Daya Listrik Terpasang Bangunan (VA)</label>
                                            <select id="installedPowerVA" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base" onchange="updateTariffRate()">
                                                <option value="">Pilih daya terpasang</option>
                                                <option value="450">450 VA (R-1/TR bersubsidi) - Rp 415/kWh</option>
                                                <option value="900">900 VA (R-1/TR bersubsidi) - Rp 605/kWh</option>
                                                <option value="900">900 VA (R-1/TR Rumah Tangga Mampu) - Rp 1.352/kWh</option>
                                                <option value="1300">1300 VA (R-1/TR) - Rp 1.444,70/kWh</option>
                                                <option value="2200">2200 VA (R-1/TR) - Rp 1.444,70/kWh</option>
                                                <option value="3500">3500 VA (R-2/TR) - Rp 1.699,53/kWh</option>
                                                <option value="4400">4400 VA (R-2/TR) - Rp 1.699,53/kWh</option>
                                                <option value="5500">5500 VA (R-2/TR) - Rp 1.699,53/kWh</option>
                                                <option value="6600">6600 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="7700">7700 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="9000">9000 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="10600">10600 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="13200">13200 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="16500">16500 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                                <option value="22000">22000 VA (R-3/TR) - Rp 1.699,53/kWh</option>
                                            </select>
                                            <div id="tariffInfo" class="mt-2 text-sm text-gray-600"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="deviceBrand" class="block text-gray-700 font-medium mb-1 text-sm sm:text-base">Brand</label>
                                    <select id="deviceBrand" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                                        <option value="">Select a Brand...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="applianceName">Appliance Name</label>
                                    <input class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" id="applianceName" placeholder="e.g. Smart TV" type="text" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="applianceCategory">Category</label>
                                    <select class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" id="applianceCategory" name="applianceCategory">
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
                                    <input class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" id="powerRating" placeholder="e.g. 120" type="number" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="dailyUsage">Daily Usage (Hours)</label>
                                    <input class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" id="dailyUsage" placeholder="e.g. 5" type="number" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="quantity">Quantity</label>
                                    <input class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" id="quantity" min="1" type="number" value="1" />
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                <button onclick="addDevice(event)" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors text-sm sm:text-base">
                                    <i class="fas fa-plus mr-2"></i>Add Device
                                </button>
                                <button id="resetCalculatorBtn" type="button" class="w-full bg-gray-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-sm sm:text-base">
                                    <i class="fas fa-undo mr-2"></i>Reset Calculator
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Device Table Section -->
                <div class="card bg-white rounded-2xl p-4 sm:p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Device List</h3>
                    </div>
                    <div id="deviceList" class="flex-grow">
                        <!-- Device table will be populated here -->
                    </div>
                    <div class="mt-6">
                        <button onclick="submitAndAnalyzeData()" class="w-full bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-sm sm:text-base" id="calculateBtn" type="button">
                            Calculate Energy Consumption
                        </button>
                    </div>
                </div>
            </div>

            <!-- AI Analysis Panel -->
            <div class="card bg-white rounded-2xl p-4 sm:p-6 mt-4 sm:mt-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">AI Analysis</h2>
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-brain text-blue-600 text-lg sm:text-xl"></i>
                    </div>
                </div>
                <div id="analysisCards" class="mt-4">
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Device Modal -->
    <div id="editDeviceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
        <div class="bg-white p-4 sm:p-6 rounded-lg w-full max-w-md">
            <h2 class="text-lg sm:text-xl font-bold mb-4">Edit Perangkat</h2>
            <form id="editDeviceForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merek</label>
                    <select id="editDeviceBrand" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                        <option value="">Pilih Merek...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perangkat</label>
                    <input type="text" id="editDeviceName" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="editApplianceCategory" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" required>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daya (Watt)</label>
                    <input type="number" id="editDevicePower" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (Jam/Hari)</label>
                    <input type="number" id="editDeviceDuration" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" min="1" max="24" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" id="editDeviceQuantity" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base" required>
                </div>
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="closeEditModal()" class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm sm:text-base">Batal</button>
                    <button type="button" onclick="updateDevice()" class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm sm:text-base">Simpan</button>
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
            updateDeviceList();
            updateTariffRate();
        });

        const strodeEmail = sessionStorage.getItem("userEmail");

        // Load brands from server with retry mechanism
        async function loadBrands(retryCount = 0) {
            const maxRetries = 3;
            const retryDelay = 1000; // 1 second

            try {
                const response = await fetch('/calculator/brands', {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'include'
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `Failed to load brands: ${response.statusText}`);
                }

                const brands = await response.json();
                console.log("Fetched brands:", brands); // Debugging

                const brandSelects = document.querySelectorAll("#deviceBrand, #editDeviceBrand");
                brandSelects.forEach(select => {
                    select.innerHTML = '<option value="">Select a Brand...</option>'; // Clear existing options
                    brands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.name; // Use brand.name for the value
                        option.textContent = brand.name; // Use brand.name for the displayed text
                        select.appendChild(option);
                    });
                    select.disabled = false;
                });

                console.log("Brands loaded successfully!");

            } catch (error) {
                console.error("Error loading brands:", error);

                if (retryCount < maxRetries) {
                    console.log(`Retrying... Attempt ${retryCount + 1} of ${maxRetries}`);
                    setTimeout(() => loadBrands(retryCount + 1), retryDelay);
                } else {
                    const errorMessage = "Failed to load brands. Please try again later.";
                    console.error(errorMessage);

                    const brandSelects = document.querySelectorAll("#deviceBrand, #editDeviceBrand");
                    brandSelects.forEach(select => {
                        select.innerHTML = '<option value="">Error loading brands</option>';
                        select.disabled = true;
                    });

                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>${errorMessage}</span>
                        </div>
                    `;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }
            }
        }

        // Toggle electricity input based on billing type
        function toggleElectricityInput() {
            const billingType = document.getElementById("billingType").value;
            console.log("Billing Type:", billingType); // Debug
            document.getElementById("tokenInput").style.display = billingType === "token" ? "block" : "none";
            document.getElementById("pascabayarInput").style.display = billingType === "pascabayar" ? "block" : "none";
        }

        // Add device function
        function addDevice(event) {
            event.preventDefault();

            const deviceBrand = document.getElementById("deviceBrand").value;
            const applianceName = document.getElementById("applianceName").value;
            const applianceCategory = document.getElementById("applianceCategory").value;
            const powerRating = parseInt(document.getElementById("powerRating").value, 10);
            const dailyUsage = parseInt(document.getElementById("dailyUsage").value, 10);
            const quantity = parseInt(document.getElementById("quantity").value, 10);

            console.log("Adding device with category:", applianceCategory); // Debug log

            if (!deviceBrand || !applianceName || !applianceCategory || isNaN(powerRating) || isNaN(dailyUsage) || isNaN(quantity)) {
                alert("Please fill in all fields correctly!");
                return;
            }

            if (dailyUsage < 1 || dailyUsage > 24) {
                alert("Daily usage must be between 1 and 24 hours!");
                return;
            }

            const newDevice = {
                brand: deviceBrand,
                name: applianceName,
                category: applianceCategory,
                power: powerRating,
                duration: dailyUsage,
                quantity: quantity
            };

            console.log("New device object:", newDevice); // Debug log

            devices.push(newDevice);
            console.log("Current devices array:", devices); // Debug log

            updateDeviceList();
            // Reset only device-specific fields, not the entire form
            document.getElementById('deviceBrand').value = '';
            document.getElementById('applianceName').value = '';
            document.getElementById('applianceCategory').value = '';
            document.getElementById('powerRating').value = '';
            document.getElementById('dailyUsage').value = '';
            document.getElementById('quantity').value = '1'; // Reset quantity to default 1
        }

        // Reset calculator
        document.getElementById('resetCalculatorBtn').addEventListener('click', function() {
            // Reset device-specific fields
            document.getElementById('deviceBrand').value = '';
            document.getElementById('applianceName').value = '';
            document.getElementById('applianceCategory').value = '';
            document.getElementById('powerRating').value = '';
            document.getElementById('dailyUsage').value = '';
            document.getElementById('quantity').value = '1';

            // Clear device list
            devices = [];
            updateDeviceList();

            // Clear analysis results
            document.getElementById('analysisCards').innerHTML = '';

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Calculator has been reset!</span>
                </div>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        });

        // Submit and analyze data
        async function submitAndAnalyzeData() {
            try {
                if (!validateForm()) {
                    return;
                }

                const billingType = document.getElementById('billingType').value;
                if (!billingType) {
                    throw new Error('Please select a billing type');
                }

                if (devices.length === 0) {
                    throw new Error('Please add at least one device');
                }

                const installedPowerVA = document.getElementById('installedPowerVA').value;
                if (!installedPowerVA) {
                    throw new Error('Please select the installed building power (VA)');
                }

                // Get electricity data based on billing type
                let electricityData = {};
                if (billingType === 'token') {
                    const tokenAmount = document.getElementById('tokenAmount').value;
                    const tokenKwh = document.getElementById('tokenKwh').value;
                    if (!tokenAmount || !tokenKwh) {
                        throw new Error('Please fill in all token fields');
                    }
                    electricityData = {
                        amount: parseFloat(tokenAmount),
                        kwh: parseFloat(tokenKwh)
                    };
                } else {
                    electricityData = {
                        amount: parseFloat(installedPowerVA),
                        kwh: parseFloat(installedPowerVA) / 1000
                    };
                }

                // Format devices data with all required fields
                const formattedDevices = devices.map(device => {
                    console.log('Processing device before formatting:', device); // Debug log
                    
                    let besarListrik;
                    if (billingType === 'token') {
                        besarListrik = `${electricityData.kwh.toFixed(2)} kWh`;
                    } else {
                        besarListrik = `${electricityData.kwh.toFixed(2)} VA`;
                    }

                    const formattedDevice = {
                        name: device.name,
                        category: device.category, // Ensure category is included without fallback
                        brand: device.brand,
                        power: parseInt(device.power),
                        duration: parseInt(device.duration),
                        quantity: parseInt(device.quantity || 1),
                        jenis_pembayaran: billingType,
                        besar_listrik: besarListrik
                    };

                    console.log('Formatted device:', formattedDevice); // Debug log
                    return formattedDevice;
                });

                const userData = {
                    billing_type: billingType,
                    electricity: electricityData,
                    devices: formattedDevices,
                    installed_power_va: parseInt(installedPowerVA)
                };

                console.log('Submitting data:', userData);

                // Show loading state
                const calculateBtn = document.getElementById('calculateBtn');
                const originalText = calculateBtn.innerHTML;
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Analyzing...';
                calculateBtn.disabled = true;

                const response = await fetch('/calculator/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(userData),
                    credentials: 'include'
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Error analyzing data');
                }

                // Update UI with results
                updateAnalysisUI(data);

            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
            } finally {
                // Reset button state
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = 'Calculate Energy Consumption';
                calculateBtn.disabled = false;
            }
        }

        function updateAnalysisUI(data) {
            const resultDiv = document.getElementById('analysisCards');
            
            // Create device analysis section
            const deviceAnalysisHtml = `
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-bold mb-4">📊 Device Analysis</h3>
                            <div class="space-y-4">
                        ${data.device_analysis.map(device => `
                                    <div class="border-b border-gray-200 pb-3">
                                        <h4 class="font-semibold text-gray-800">${device.name}</h4>
                                        <p class="text-gray-600 text-sm">${device.category}</p>
                                        <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                                            <div>Daily Consumption:</div>
                                            <div class="text-right">${device.daily_consumption} kWh</div>
                                            <div>Monthly Consumption:</div>
                                            <div class="text-right">${device.monthly_consumption} kWh</div>
                                            <div>Cost Monthly:</div>
                                            <div class="text-right">Rp ${(device.monthly_cost || 0).toLocaleString('id-ID')}</div>
                                        </div>
                                    </div>
                                `).join('')}
                                <div class="mt-4 pt-3 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Total Monthly Consumption:</span>
                                        <span class="text-lg font-bold text-blue-600">${data.total_consumption} kWh</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="font-semibold">Total Monthly Cost:</span>
                                        <span class="text-lg font-bold text-green-600">Rp ${(data.total_cost || 0).toLocaleString('id-ID')}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

            // Create AI analysis section
            const aiAnalysisHtml = `
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-bold mb-4">💡 AI Recommendations</h3>
                            <div class="prose prose-sm max-w-none">
                        ${data.ai_response.split('\n').map(line => `
                                    <p class="mb-2">${line}</p>
                                `).join('')}
                            </div>
                        </div>
            `;

            // Update the UI
            resultDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    ${deviceAnalysisHtml}
                    ${aiAnalysisHtml}
                    </div>
                `;

                // Show success notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Analysis completed successfully!</span>
                    </div>
                `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 5000);
        }

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
                if (parseFloat(tokenAmount) <= 0 || parseFloat(tokenKwh) <= 0) {
                    alert("Token amount and kWh must be greater than 0!");
                    return false;
                }
            } else if (billingType === "pascabayar") {
                const installedPowerVA = document.getElementById("installedPowerVA").value;
                if (!installedPowerVA) {
                    alert("Please select the installed building power (VA)!");
                    return false;
                }
            }

            if (devices.length === 0) {
                alert("Please add at least one device!");
                return false;
            }

            // Validate each device
            for (const device of devices) {
                if (!device.brand || !device.name || !device.power || !device.duration) {
                    alert("All device fields are required!");
                    return false;
                }
                if (device.power <= 0) {
                    alert("Device power must be greater than 0!");
                    return false;
                }
                if (device.duration < 1 || device.duration > 24) {
                    alert("Device duration must be between 1 and 24 hours!");
                    return false;
                }
                if (!device.quantity || device.quantity < 1) {
                    alert("Device quantity must be at least 1!");
                    return false;
                }
            }

            return true;
        }

        // Function to open the edit modal and populate with device data
        function openEditModal(index) {
            editIndex = index;
            const device = devices[index];
            document.getElementById("editDeviceBrand").value = device.brand;
            document.getElementById("editDeviceName").value = device.name;
            document.getElementById("editApplianceCategory").value = device.category; // Set category for edit
            document.getElementById("editDevicePower").value = device.power;
            document.getElementById("editDeviceDuration").value = device.duration;
            document.getElementById("editDeviceQuantity").value = device.quantity;
            document.getElementById("editDeviceModal").classList.remove("hidden");
        }

        // Function to update device data from the edit modal
        function updateDevice() {
            if (editIndex === -1) return;

            const brand = document.getElementById('editDeviceBrand').value;
            const name = document.getElementById('editDeviceName').value;
            const category = document.getElementById('editApplianceCategory').value;
            const power = document.getElementById('editDevicePower').value;
            const duration = document.getElementById('editDeviceDuration').value;
            const quantity = document.getElementById('editDeviceQuantity').value;

            console.log("Updating device with category:", category); // Debug log

            if (!brand || !name || !category || !power || !duration || !quantity) {
                alert('Please fill in all fields');
                return;
            }

            const updatedDevice = {
                brand,
                name,
                category,
                power: parseInt(power),
                duration: parseInt(duration),
                quantity: parseInt(quantity)
            };

            console.log("Updated device object:", updatedDevice); // Debug log

            devices[editIndex] = updatedDevice;
            console.log("Current devices array after update:", devices); // Debug log

            updateDeviceList();
            closeEditModal();
        }

        // Function to close the edit modal
        function closeEditModal() {
            document.getElementById("editDeviceModal").classList.add("hidden");
        }

        // Update device list display
        function updateDeviceList() {
            const deviceList = document.getElementById('deviceList');
            if (devices.length === 0) {
                deviceList.innerHTML = `
                    <div class="text-center text-gray-500 py-4">
                        No devices added yet
                    </div>
                `;
                return;
            }

            const table = document.createElement('table');
            table.className = 'min-w-full divide-y divide-gray-200 responsive-table';

            const thead = document.createElement('thead');
            thead.className = 'bg-gray-50';

            const headerRow = document.createElement('tr');
            headerRow.innerHTML = `
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appliance</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power (Watt)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Daily Usage (Hours)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            `;
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            tbody.className = 'bg-white divide-y divide-gray-200';

            devices.forEach((device, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Brand">${device.brand}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Appliance">${device.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Category">${device.category || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Power (Watt)">${device.power}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Daily Usage (Hours)">${device.duration}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" data-label="Quantity">${device.quantity}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" data-label="Actions">
                        <button onclick="openEditModal(${index})" class="text-indigo-600 hover:text-indigo-900 mr-2">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="removeDevice(${index})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            deviceList.innerHTML = ''; // Clear existing content
            deviceList.appendChild(table);
        }

        function updateTariffRate() {
            const installedPowerVA = document.getElementById('installedPowerVA').value;
            const tariffInfo = document.getElementById('tariffInfo');
            let tariffRate = 0;
            let tariffType = '';

            switch (parseInt(installedPowerVA)) {
                case 450:
                    tariffRate = 415;
                    tariffType = 'R-1/TR bersubsidi';
                    break;
                case 900:
                    // Check if it's subsidized or non-subsidized
                    const selectedOption = document.getElementById('installedPowerVA').options[document.getElementById('installedPowerVA').selectedIndex];
                    if (selectedOption.text.includes('bersubsidi')) {
                        tariffRate = 605;
                        tariffType = 'R-1/TR bersubsidi';
                    } else {
                        tariffRate = 1352;
                        tariffType = 'R-1/TR Rumah Tangga Mampu';
                    }
                    break;
                case 1300:
                case 2200:
                    tariffRate = 1444.70;
                    tariffType = 'R-1/TR';
                    break;
                case 3500:
                case 4400:
                case 5500:
                    tariffRate = 1699.53;
                    tariffType = 'R-2/TR';
                    break;
                case 6600:
                case 7700:
                case 9000:
                case 10600:
                case 13200:
                case 16500:
                case 22000:
                    tariffRate = 1699.53;
                    tariffType = 'R-3/TR';
                    break;
                default:
                    tariffRate = 0;
                    tariffType = '';
            }

            if (tariffRate > 0) {
                tariffInfo.innerHTML = `Tarif Listrik: Rp ${tariffRate.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})} per kWh (${tariffType})`;
            } else {
                tariffInfo.innerHTML = '';
            }
        }

        function removeDevice(index) {
            devices.splice(index, 1);
            updateDeviceList();
        }

        function clearDeviceForm() {
            document.getElementById("deviceBrand").value = "";
            document.getElementById("applianceName").value = "";
            document.getElementById("applianceCategory").value = "";
            document.getElementById("powerRating").value = "";
            document.getElementById("dailyUsage").value = "";
            document.getElementById("quantity").value = "1";
        }
    </script>
</body>
</html>