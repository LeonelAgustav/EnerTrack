<nav class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white p-4">
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-blue-600"></i>
                </div>
                <span class="text-2xl font-bold">EnerTrack</span>
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
                <a href="{{ url('/profile') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-user"></i>
                    <span class="font-medium">Profile</span>
                </a>
                <a href="{{ url('/logout') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="font-medium">Logout</span>
                </a>
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
            <a href="{{ url('/profile') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
                <i class="fas fa-user"></i>
                <span class="font-medium">Profile</span>
            </a>
            <a href="{{ url('/logout') }}" class="nav-item flex items-center space-x-2 hover:bg-white/20 px-4 py-2 rounded-lg cursor-pointer">
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
</script>