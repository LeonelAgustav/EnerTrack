<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>History</title>
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
        /* Loading spinner */
        .loading-spinner {
            display: none;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading .loading-spinner {
            display: block;
        }
        /* Empty state */
        .empty-state {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        .empty-state.active {
            display: block;
        }
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        /* Error state */
        .error-state {
            display: none;
            text-align: center;
            padding: 2rem;
            color: #ef4444;
        }
        .error-state.active {
            display: block;
        }
        /* Responsive table styles */
        @media (max-width: 768px) {
            .responsive-history-table {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .responsive-history-table thead {
                display: none !important;
            }
            
            .responsive-history-table tbody {
                display: block !important;
                width: 100%;
            }
            
            .responsive-history-table tr {
                display: block !important;
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.5rem;
            }
            
            .responsive-history-table td {
                display: flex !important;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem;
                border: none;
                border-bottom: 1px solid #f3f4f6;
            }
            
            .responsive-history-table td:last-child {
                border-bottom: none;
            }
            
            .responsive-history-table td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <main class="p-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">History</h1>
                <p class="text-gray-600">View your calculation history</p>
            </div>
        </div>

        <!-- Calculation History Table -->
        <div class="card bg-white rounded-2xl p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800 text-center sm:text-left mb-4 sm:mb-0">Calculation History</h2>
                <div class="flex flex-col md:flex-row space-y-3 md:space-x-3 md:space-y-0 mt-4 md:mt-0 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text" id="searchInput" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="categoryFilter" class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Cooling">Cooling</option>
                        <option value="Lighting">Lighting</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="Health">Health</option>
                    </select>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="flex justify-center items-center py-2">
                <div class="loading-spinner"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state">
                <i class="fas fa-history"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No History Found</h3>
                <p class="text-gray-500">Start calculating your energy usage to see your history here.</p>
            </div>

            <!-- Error State -->
            <div id="errorState" class="error-state">
                <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Error Loading History</h3>
                <p class="text-gray-600">Please try again later.</p>
            </div>

            <!-- Table -->
            <div id="tableContainer" class="w-full">
                <table class="text-sm text-left text-gray-700 responsive-history-table w-full">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 md:table-header-group">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Appliance</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3">Power (W)</th>
                            <th class="px-6 py-3">Usage (Hrs)</th>
                            <th class="px-6 py-3">Daily (kWh)</th>
                            <th class="px-6 py-3">Monthly (kWh)</th>
                            <th class="px-6 py-3">Cost</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <!-- Data will be loaded dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-3 md:space-y-0">
                <div class="text-sm text-gray-500">
                    Showing <span id="startEntry" class="font-medium">0</span> to <span id="endEntry" class="font-medium">0</span> of <span id="totalEntries" class="font-medium">0</span> entries
                </div>
                <div class="flex flex-wrap gap-2 justify-between" id="pagination">
                    <!-- Pagination will be loaded dynamically -->
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>

        // Function to format date
        function formatDate(dateString) {
            const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        // Function to format currency (Rupiah)
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        // Function to get category badge class
        function getCategoryBadgeClass(category) {
            const classes = {
                'Entertainment': 'bg-blue-100 text-blue-800',
                'Cooling': 'bg-green-100 text-green-800',
                'Lighting': 'bg-yellow-100 text-yellow-800',
                'Kitchen': 'bg-red-100 text-red-800',
                'Health': 'bg-purple-100 text-purple-800'
            };
            return classes[category] || 'bg-gray-100 text-gray-800';
        }

        // Function to show loading state
        function showLoading() {
            document.getElementById('loadingState').classList.add('loading');
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('emptyState').classList.remove('active');
            document.getElementById('errorState').classList.remove('active');
        }

        // Function to hide loading state
        function hideLoading() {
            document.getElementById('loadingState').classList.remove('loading');
            document.getElementById('tableContainer').style.display = 'block';
        }

        // Function to show empty state
        function showEmptyState() {
            document.getElementById('emptyState').classList.add('active');
            document.getElementById('tableContainer').style.display = 'none';
        }

        // Function to show error state
        function showErrorState() {
            document.getElementById('errorState').classList.add('active');
            document.getElementById('tableContainer').style.display = 'none';
        }

        // Function to render history table
        function renderHistoryTable(calculations) {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = '';

            if (calculations.length === 0) {
                showEmptyState();
                return;
            }

            calculations.forEach(calc => {
                const row = document.createElement('tr');
                row.className = 'table-row border-b hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4" data-label="Date">${formatDate(calc.date)}</td>
                    <td class="px-6 py-4" data-label="Appliance">
                        <div class="font-medium">${calc.appliance}</div>
                        <div class="text-xs text-gray-500">${calc.model}</div>
                    </td>
                    <td class="px-6 py-4" data-label="Category">
                        <span class="px-2 py-1 ${getCategoryBadgeClass(calc.category)} rounded-full text-xs">${calc.category}</span>
                    </td>
                    <td class="px-6 py-4" data-label="Power (W)">${calc.power}</td>
                    <td class="px-6 py-4" data-label="Usage (Hrs)">${calc.usage_hours}</td>
                    <td class="px-6 py-4" data-label="Daily (kWh)">${calc.daily_kwh.toFixed(2)}</td>
                    <td class="px-6 py-4" data-label="Monthly (kWh)">${calc.monthly_kwh.toFixed(2)}</td>
                    <td class="px-6 py-4" data-label="Cost">${formatCurrency(calc.cost)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // Function to update pagination info
        function updatePaginationInfo(start, end, total) {
            document.getElementById('startEntry').textContent = start;
            document.getElementById('endEntry').textContent = end;
            document.getElementById('totalEntries').textContent = total;
        }

        // Function to render pagination
        function renderPagination(currentPage, totalPages) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            // Previous button
            const prevButton = document.createElement('button');
            prevButton.className = `px-2 sm:px-3 py-1 border border-gray-300 rounded-lg flex-shrink-0 ${currentPage === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`;
            prevButton.innerHTML = `<span class="hidden sm:inline">Previous</span><i class="fas fa-angles-left text-lg block sm:hidden"></i>`;
            prevButton.disabled = currentPage === 1;
            prevButton.onclick = () => loadCalculations(currentPage - 1);
            pagination.appendChild(prevButton);

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.className = `px-2 sm:px-3 py-1 border border-gray-300 rounded-lg flex-shrink-0 ${i == currentPage ? 'bg-blue-500 text-white' : 'hover:bg-gray-100'}`;
                pageButton.textContent = i;
                pageButton.onclick = () => loadCalculations(i);
                pagination.appendChild(pageButton);prevButton.disabled = currentPage <= 1;
            }

            // Next button
            const nextButton = document.createElement('button');
            nextButton.className = `px-2 sm:px-3 py-1 border border-gray-300 rounded-lg flex-shrink-0 ${currentPage === totalPages ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'hover:bg-gray-100'}`;
            nextButton.innerHTML = `<span class="hidden sm:inline">Next</span><i class="fas fa-angles-right text-lg block sm:hidden"></i>`;
            nextButton.disabled = currentPage === totalPages;
            nextButton.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                loadCalculations(currentPage);
            }
            };
            pagination.appendChild(nextButton);
        }

        // Function to load calculations
        async function loadCalculations(page = 1) {
            try {
                showLoading();
                
                const searchQuery = document.getElementById('searchInput').value;
                const category = document.getElementById('categoryFilter').value;

                console.log('Sending category:', category); // Log the category being sent
                
                const response = await fetch(`/history/calculations?page=${page}&search=${searchQuery}&category=${encodeURIComponent(category)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'include'
                });

                if (!response.ok) {
                    throw new Error('Failed to load history');
                }

                const data = await response.json();

                console.log('Received pagination data from backend:', data.data.pagination); // Added for debugging

                if (data.success) {
                    hideLoading();
                    renderHistoryTable(data.data.calculations);
                    updatePaginationInfo(
                        data.data.pagination.start,
                        data.data.pagination.end,
                        data.data.pagination.total
                    );
                    renderPagination(
                        data.data.pagination.current_page,
                        data.data.pagination.last_page
                    );
                } else {
                    showErrorState();
                }
            } catch (error) {
                console.error('Error loading calculations:', error);
                showErrorState();
            }
        }

        // Event listeners
        console.log('Attaching event listeners.'); // Added for debugging
        const categoryFilterElement = document.getElementById('categoryFilter');
        const searchInputElement = document.getElementById('searchInput');
        
        console.log('Category filter element found:', categoryFilterElement); // Added for debugging
        console.log('Search input element found:', searchInputElement); // Added for debugging

        // Add event listeners with debugging
        searchInputElement.addEventListener('input', function(e) {
            console.log('Search input changed:', e.target.value);
            debounce(() => loadCalculations(1), 300)();
        });

        categoryFilterElement.addEventListener('change', function(e) {
            console.log('Category filter changed:', e.target.value);
            loadCalculations(1);
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Initial load
        console.log('Performing initial load...');
        loadCalculations();
    </script>
</body>
</html>