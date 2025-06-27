<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="card bg-white rounded-2xl p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <div class="w-32 h-32 bg-blue-100 rounded-full profile-avatar flex items-center justify-center text-blue-600 text-4xl font-bold">
                                AN
                            </div>
                            <div class="absolute bottom-0 right-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white cursor-pointer hover:bg-blue-600">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Aspara Nagato</h2>
                        <p class="text-gray-500 mb-4">Energy Analyst</p>
                        <div class="w-full bg-gray-100 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Profile Completion</span>
                                <span class="text-sm font-medium text-blue-600">85%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="w-full space-y-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mr-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium">aspara.n@example.com</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mr-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium">+62 812 3456 7890</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="font-medium">Pasuruan, Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="lg:col-span-2">
                <div class="card bg-white rounded-2xl p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Account Settings</h3>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" value="Aspara" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" value="Nagato" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="aspara.n@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" value="+62 812 3456 7890" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>Indonesia</option>
                                    <option>Malaysia</option>
                                    <option>Singapore</option>
                                    <option>Thailand</option>
                                    <option>Vietnam</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>English</option>
                                    <option>Bahasa Indonesia</option>
                                    <option>Japanese</option>
                                    <option>Jawa</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">Jl. Sudirman No. 123, Jakarta Selatan</textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 mr-3 hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Security Settings -->
                <div class="card bg-white rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Security Settings</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600 mr-4">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Password</h4>
                                    <p class="text-sm text-gray-500">Last changed 3 months ago</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Change</button>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mr-4">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Two-Factor Authentication</h4>
                                    <p class="text-sm text-gray-500">Add extra layer of security</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-500 mr-3">Disabled</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                                    <i class="fas fa-link"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Connected Accounts</h4>
                                    <p class="text-sm text-gray-500">Google, Facebook, Twitter, Apple</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">Manage</button>
                        </div>

                        <div class="flex items-center justify-between p-4 border border-red-100 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600 mr-4">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Delete Account</h4>
                                    <p class="text-sm text-gray-500">Permanently remove your account</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Simple animation for progress bar on page load
        document.addEventListener('DOMContentLoaded', function() {
            const progressFill = document.querySelector('.progress-fill');
            // Trigger reflow to restart animation
            progressFill.style.width = '0';
            setTimeout(() => {
                progressFill.style.width = '85%';
            }, 100);
        });
    </script>
</body>

</html>