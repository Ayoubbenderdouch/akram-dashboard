<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Akram Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            transform: translateX(5px);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex">
        <aside class="w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 min-h-screen shadow-2xl">
            <div class="p-6">
                <div class="flex items-center space-x-2 mb-8">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-indigo-600 text-xl"></i>
                    </div>
                    <span class="font-bold text-white text-xl">Akram</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('statistics') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('statistics') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="font-medium">Statistics</span>
                    </a>

                    <a href="{{ route('users.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="font-medium">Users</span>
                    </a>

                    <a href="{{ route('products.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('products.*') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-box w-5"></i>
                        <span class="font-medium">Products</span>
                    </a>

                    <a href="{{ route('orders.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('orders.*') && !request()->routeIs('custom-orders.*') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span class="font-medium">Orders</span>
                    </a>

                    <a href="{{ route('custom-orders.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('custom-orders.*') ? 'bg-white bg-opacity-20 text-white' : 'text-indigo-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-star w-5"></i>
                        <span class="font-medium">Custom Orders</span>
                    </a>
                </nav>
            </div>

            <div class="absolute bottom-0 w-64 p-6">
                <div class="bg-white bg-opacity-10 rounded-lg p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-indigo-200 text-xs">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 px-4 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-all text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm">
                <div class="px-8 py-6">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                    <p class="text-gray-500 text-sm mt-1">@yield('subtitle', 'Manage your business operations')</p>
                </div>
            </header>

            <div class="px-8 py-8">
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>