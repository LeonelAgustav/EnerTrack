<nav class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white p-4">
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-blue-600"></i>
                </div>
                <a class="text-2xl font-bold">EnerTrack</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg hover:bg-white/20">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="{{ url('/dashboard') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-home"></i>
                    <span class="font-medium">Home</span>
                </a>
                <a href="{{ url('/calculator') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-calculator"></i>
                    <span class="font-medium">Calculate</span>
                </a>
                <a href="{{ url('/history') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-history"></i>
                    <span class="font-medium">History</span>
                </a>
                <a href="{{ url('/analysis') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-chart-line"></i>
                    <span class="font-medium">Analytics</span>
                </a>
            </div>

            <!-- Desktop Profile Menu -->
            <div class="hidden lg:flex items-center space-x-4">
                <div class="relative">
                    <button id="profile-menu-button" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                        <div id="sidebarProfileInitials" class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-sm font-bold select-none">
                            <!-- Initials will be inserted here -->
                        </div>
                    </button>
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 hidden">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div id="dropdownProfileInitials" class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold select-none">
                                    <!-- Initials will be inserted here -->
                                </div>
                                <div>
                                    <p id="dropdownProfileName" class="text-gray-900 font-medium capitalize"></p>
                                    <a href="{{ url('/profile') }}" class="text-sm text-gray-500">View Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 my-1"></div>
                        <a href="{{ url('/logout') }}" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden mt-4 space-y-2">
            <a href="{{ url('/dashboard') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-home"></i>
                <span class="font-medium">Home</span>
            </a>
            <a href="{{ url('/calculator') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-calculator"></i>
                <span class="font-medium">Calculate</span>
            </a>
            <a href="{{ url('/history') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-history"></i>
                <span class="font-medium">History</span>
            </a>
            <a href="{{ url('/analysis') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-chart-line"></i>
                <span class="font-medium">Analytics</span>
            </a>
            <div class="border-t border-white/20 my-2"></div>
            <a href="{{ url('/profile') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-user-circle"></i>
                <span class="font-medium">My Profile</span>
            </a>
            <a href="{{ url('/logout') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer text-red-300">
                <i class="fas fa-sign-out-alt"></i>
                <span class="font-medium">Logout</span>
            </a>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle functionality
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });

    // Profile menu toggle functionality
    const profileButton = document.getElementById('profile-menu-button');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    profileButton.addEventListener('click', function() {
        profileDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });

    // Helper to get initials
    function getSidebarInitials(name) {
        if (!name) return '';
        return name
            .split(' ')
            .map(word => word[0])
            .join('')
            .toUpperCase()
            .slice(0, 2);
    }

    // Fetch profile for sidebar
    async function fetchSidebarProfile() {
        try {
            const response = await fetch('/api/user/profile', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });
            if (!response.ok) return;
            const data = await response.json();
            const initials = getSidebarInitials(data.fullname);
            document.getElementById('sidebarProfileInitials').textContent = initials;
            document.getElementById('dropdownProfileInitials').textContent = initials;
            document.getElementById('dropdownProfileName').textContent = data.fullname;
        } catch (e) {
            // fallback: hide or show default
        }
    }
    document.addEventListener('DOMContentLoaded', fetchSidebarProfile);
</script>