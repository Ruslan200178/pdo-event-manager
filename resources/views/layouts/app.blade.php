<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PDO Portal') - District Secretariat</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind compiled by Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="h-full flex flex-col overflow-hidden">

    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-50 flex flex-col gap-2">
        @if(session('success'))
            <div class="toast-alert flex items-center p-4 mb-4 text-gray-800 bg-white border-l-4 border-emerald-500 rounded-lg shadow-lg max-w-sm transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-50 rounded-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="ml-3 text-sm font-medium text-gray-600">{{ session('success') }}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.parentElement.remove()" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="toast-alert flex items-center p-4 mb-4 text-gray-800 bg-white border-l-4 border-rose-500 rounded-lg shadow-lg max-w-sm transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-rose-500 bg-rose-50 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="ml-3 text-sm font-medium text-gray-600">
                    {{ session('error') ?? $errors->first() }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.parentElement.remove()" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Container -->
    <div class="flex flex-1 overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="hidden md:flex md:flex-col md:w-64 bg-govblue-900 text-white flex-shrink-0 shadow-xl border-r border-govblue-800">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between px-6 h-16 bg-govblue-950 border-b border-govblue-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white rounded-md flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-building-columns text-govblue-900 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight tracking-wider">PDO PORTAL</h1>
                        <p class="text-[10px] text-blue-200 tracking-wider">DIVS secretariat</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1">
                @php
                    $route = Route::currentRouteName();
                    $navItems = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-gauge'],
                        ['route' => 'npc.index', 'label' => 'National Productivity', 'icon' => 'fa-award', 'active' => 'npc.*'],
                        ['route' => 'cmv.index', 'label' => 'Model Village Program', 'icon' => 'fa-house-chimney-window', 'active' => 'cmv.*'],
                        ['route' => 'citizen-mirror.index', 'label' => 'Citizen Mirror', 'icon' => 'fa-users-viewfinder', 'active' => 'citizen-mirror.*'],
                        ['route' => 'proyouth.index', 'label' => 'ProYouth Program', 'icon' => 'fa-rocket', 'active' => 'proyouth.*'],
                        ['route' => 'fouri.index', 'label' => '4i Project', 'icon' => 'fa-circle-info', 'active' => 'fouri.*'],
                        ['route' => 'letters.index', 'label' => 'Letter Management', 'icon' => 'fa-envelope-open-text', 'active' => 'letters.*'],
                        ['route' => 'five-s.index', 'label' => '5S Certification', 'icon' => 'fa-certificate', 'active' => 'five-s.*'],
                        ['route' => 'courses.index', 'label' => 'Certification Course', 'icon' => 'fa-graduation-cap', 'active' => 'courses.*'],
                        ['route' => 'training.index', 'label' => 'Training Program', 'icon' => 'fa-chalkboard-user', 'active' => 'training.*'],
                        ['route' => 'officers.index', 'label' => 'Productivity Officers', 'icon' => 'fa-user-tie', 'active' => 'officers.*'],
                        ['route' => 'reports.index', 'label' => 'Reports & Exports', 'icon' => 'fa-file-invoice-dollar', 'active' => 'reports.*'],
                        ['route' => 'gallery.index', 'label' => 'Image Gallery', 'icon' => 'fa-images', 'active' => 'gallery.*'],
                        ['route' => 'archive.index', 'label' => 'Past Archives', 'icon' => 'fa-folder-closed', 'active' => 'archive.*'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = false;
                        if (isset($item['active'])) {
                            $isActive = str_contains($route, str_replace('*', '', $item['active']));
                        } else {
                            $isActive = $route === $item['route'];
                        }
                    @endphp
                    <a href="{{ route($item['route']) }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ $isActive ? 'bg-govblue-700 text-white shadow-md' : 'text-blue-100 hover:bg-govblue-800 hover:text-white' }}">
                        <i class="fa-solid {{ $item['icon'] }} w-6 text-base group-hover:scale-110 transition-transform duration-200"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 bg-govblue-950 border-t border-govblue-800 flex flex-col gap-2">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-govblue-900 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-full bg-govblue-800 border-2 border-white/20 overflow-hidden flex items-center justify-center">
                        @if(auth()->user()->photo)
                            <img src="{{ asset(auth()->user()->photo) }}" alt="PDO Photo" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user text-white text-base"></i>
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-semibold truncate">{{ auth()->user()->name }}</h4>
                        <p class="text-[10px] text-blue-300 truncate">Productivity Officer</p>
                    </div>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-rose-600/20 hover:bg-rose-600 text-rose-200 hover:text-white rounded-lg text-xs font-semibold transition-all duration-200">
                        <i class="fa-solid fa-power-off"></i>
                        <span>Logout Portal</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Right Content Column -->
        <main class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-10 shadow-sm">
                <!-- Left Details -->
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-500 focus:outline-none" onclick="toggleMobileMenu()">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 tracking-tight">Sri Lanka District Secretariat</h2>
                        <p class="text-xs text-gray-500">District Productivity Development Office</p>
                    </div>
                </div>

                <!-- Right Menu items -->
                <div class="flex items-center gap-4">
                    @php
                        $unreadNotifications = App\Models\Notification::where('read', false)->latest()->take(5)->get();
                        $unreadCount = App\Models\Notification::where('read', false)->count();
                    @endphp
                    <!-- Notification Bell Dropdown -->
                    <div class="relative">
                        <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors focus:outline-none relative" onclick="toggleNotifications()">
                            <i class="fa-solid fa-bell text-lg"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold border-2 border-white animate-pulse">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown Box -->
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 bg-govblue-900 text-white flex justify-between items-center">
                                <span class="font-bold text-sm">System Notifications</span>
                                @if($unreadCount > 0)
                                    <span class="text-xs bg-rose-500 text-white px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} New</span>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                                @forelse($unreadNotifications as $notif)
                                    <div class="p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start gap-2">
                                            <h5 class="text-xs font-bold text-gray-800">{{ $notif->title }}</h5>
                                            <span class="text-[9px] text-gray-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-[11px] text-gray-600 mt-1 line-clamp-2 leading-relaxed">{{ $notif->message }}</p>
                                        <div class="flex justify-end gap-2 mt-2">
                                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] text-govblue-600 hover:underline font-semibold">Mark Read</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-gray-400 text-xs">
                                        <i class="fa-solid fa-bell-slash text-2xl mb-2 block text-gray-300"></i>
                                        No new notifications
                                    </div>
                                @endforelse
                            </div>
                            <div class="px-4 py-2.5 bg-gray-50 text-center border-t border-gray-100">
                                <a href="{{ route('notifications.index') }}" class="text-xs text-govblue-900 font-bold hover:underline">View All Notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Photo Link -->
                    <div class="flex items-center gap-3 border-l border-gray-200 pl-4">
                        <a href="{{ route('profile') }}" class="w-10 h-10 rounded-full overflow-hidden border-2 border-govblue-500 flex items-center justify-center hover:opacity-90 transition-opacity">
                            @if(auth()->user()->photo)
                                <img src="{{ asset(auth()->user()->photo) }}" alt="PDO User" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-govblue-100 text-govblue-950 flex items-center justify-center font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </a>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Frame -->
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>

            <!-- Portal Footer -->
            <footer class="h-10 bg-white border-t border-gray-200 flex items-center justify-between px-6 text-xs text-gray-500 flex-shrink-0">
                <span>© {{ date('Year', strtotime('2026-06-13')) }} Sri Lanka District Secretariat. All Rights Reserved.</span>
                <span>Version 1.0.0 (Productivity Development)</span>
            </footer>
        </main>
    </div>

    <!-- Mobile Drawer Menu Overlay -->
    <div id="mobile-menu" class="hidden fixed inset-0 z-40 flex md:hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" onclick="toggleMobileMenu()"></div>
        <!-- Drawer Body -->
        <div class="relative flex flex-col flex-1 w-full max-w-xs bg-govblue-900 text-white shadow-2xl">
            <div class="flex items-center justify-between px-6 h-16 bg-govblue-950 border-b border-govblue-800 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white rounded-md flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-building-columns text-govblue-900 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm leading-tight tracking-wider">PDO PORTAL</h1>
                    </div>
                </div>
                <button onclick="toggleMobileMenu()" class="text-white hover:text-blue-300">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1">
                @foreach($navItems as $item)
                    @php
                        $isActive = false;
                        if (isset($item['active'])) {
                            $isActive = str_contains($route, str_replace('*', '', $item['active']));
                        } else {
                            $isActive = $route === $item['route'];
                        }
                    @endphp
                    <a href="{{ route($item['route']) }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $isActive ? 'bg-govblue-700 text-white shadow-md' : 'text-blue-100 hover:bg-govblue-800 hover:text-white' }}" onclick="toggleMobileMenu()">
                        <i class="fa-solid {{ $item['icon'] }} w-6 text-base"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-4 bg-govblue-950 border-t border-govblue-800 flex flex-col gap-2">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-govblue-900 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-govblue-800 border-2 border-white/20 overflow-hidden flex items-center justify-center">
                        @if(auth()->user()->photo)
                            <img src="{{ asset(auth()->user()->photo) }}" alt="PDO Photo" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user text-white text-base"></i>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold">{{ auth()->user()->name }}</h4>
                        <p class="text-[10px] text-blue-300">Productivity Officer</p>
                    </div>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-rose-600/20 hover:bg-rose-600 text-rose-200 hover:text-white rounded-lg text-xs font-semibold transition-all">
                        <i class="fa-solid fa-power-off"></i>
                        <span>Logout Portal</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const el = document.getElementById('mobile-menu');
            el.classList.toggle('hidden');
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notifications-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notifications-dropdown');
            const bellBtn = dropdown?.previousElementSibling;
            if (dropdown && !dropdown.contains(e.target) && !bellBtn.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Autoclose Toast notifications after 4 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.toast-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
