<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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

        .profile-avatar {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            transition: width 0.6s ease;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <main class="p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profile</h1>
                <p class="text-gray-600">Manage your account settings</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-8">
                            <div class="w-32 h-32 bg-blue-100 rounded-full profile-avatar flex items-center justify-center text-blue-600 text-4xl font-bold" id="profileInitials">
                                AN
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6" id="profileName">Aspara Nagato</h2>
                        <div class="w-full space-y-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">FullName</p>
                                    <p class="font-medium" id="profileFullname">Aspara Nagato</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Username</p>
                                    <p class="font-medium" id="profileUsername">aspara.n</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium" id="profileEmail">aspara.n@example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="lg:col-span-2">
                <div class="card bg-white rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Account Settings</h3>
                    <form id="profileForm">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="fullnameInput" value="Aspara Nagato" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" id="usernameInput" value="aspara.n" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="emailInput" value="aspara.n@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 mr-3 hover:bg-gray-50">Cancel</button>
                            <button type="submit" id="saveButton" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Function to get initials from full name
        function getInitials(fullname) {
            if (!fullname) return '';
            return fullname
                .split(' ')
                .map(word => word[0])
                .join('')
                .toUpperCase()
                .slice(0, 2);
        }

        // Call fetchUserProfile when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            fetchUserProfile();
        });

        // Function to fetch user profile
        async function fetchUserProfile() {
            try {
                const response = await fetch('/api/user/profile', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        // Redirect to login if unauthorized
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error('Failed to fetch profile');
                }

                const data = await response.json();
                
                // Update profile card
                document.getElementById('profileInitials').textContent = getInitials(data.fullname);
                document.getElementById('profileName').textContent = data.fullname;
                document.getElementById('profileFullname').textContent = data.fullname;
                document.getElementById('profileUsername').textContent = data.username;
                document.getElementById('profileEmail').textContent = data.email;

                // Update form inputs
                document.getElementById('fullnameInput').value = data.fullname;
                document.getElementById('usernameInput').value = data.username;
                document.getElementById('emailInput').value = data.email;

            } catch (error) {
                console.error('Error fetching profile:', error);
                // Show error message to user
                alert('Failed to load profile data. Please try again later.');
            }
        }

        // Function to update profile
        async function updateProfile(formData) {
            const saveButton = document.getElementById('saveButton');
            const originalButtonText = saveButton.textContent;
            
            try {
                // Disable button and show loading state
                saveButton.disabled = true;
                saveButton.textContent = 'Saving...';
                saveButton.classList.add('opacity-75');

                const response = await fetch('/api/user/profile/update', {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 401) {
                        // Redirect to login if unauthorized
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(data.message || 'Failed to update profile');
                }

                // Update profile display
                document.getElementById('profileInitials').textContent = getInitials(formData.fullname);
                document.getElementById('profileName').textContent = formData.fullname;
                document.getElementById('profileFullname').textContent = formData.fullname;
                document.getElementById('profileUsername').textContent = formData.username;
                document.getElementById('profileEmail').textContent = formData.email;

                // Show success message
                showNotification('Profile updated successfully!', 'success');

            } catch (error) {
                console.error('Error updating profile:', error);
                showNotification(error.message || 'Failed to update profile. Please try again.', 'error');
            } finally {
                // Re-enable button and restore original text
                saveButton.disabled = false;
                saveButton.textContent = originalButtonText;
                saveButton.classList.remove('opacity-75');
            }
        }

        // Function to show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white z-50 transition-opacity duration-300`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Add form submission handler
        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                fullname: document.getElementById('fullnameInput').value.trim(),
                username: document.getElementById('usernameInput').value.trim(),
                email: document.getElementById('emailInput').value.trim()
            };

            // Basic validation
            if (!formData.fullname || !formData.username || !formData.email) {
                showNotification('All fields are required', 'error');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }

            await updateProfile(formData);
        });

        // Add cancel button handler
        document.querySelector('button[type="button"]').addEventListener('click', function() {
            // Reset form to current profile data
            fetchUserProfile();
        });
    </script>
</body>

</html>