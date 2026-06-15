@extends('layouts.app')

@section('title', 'Productivity Officer Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-govblue-900 to-govblue-700 text-white p-6 rounded-2xl shadow-md">
        <div>
            <h1 class="text-2xl font-bold tracking-tight"><span id="live-greeting">Good Day</span>, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-blue-100 mt-1">Welcome to the District Secretariat Productivity and Event Management Portal. Manage, audit, and analyze regional development programs.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs bg-white/20 px-3 py-1.5 rounded-full font-semibold border border-white/10 flex items-center gap-1.5">
                <i class="fa-regular fa-calendar-check"></i>
                <span id="live-date">Loading date...</span>
            </span>
            <span class="text-xs bg-white/20 px-3 py-1.5 rounded-full font-semibold border border-white/10 flex items-center gap-1.5">
                <i class="fa-regular fa-clock"></i>
                <span id="live-clock">Loading time...</span>
            </span>
        </div>
    </div>

    <!-- Analytics Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Programs Card -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-2">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Programs</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $totalPrograms }}</h3>
                <p class="text-[10px] text-gray-400">Total count of development initiatives</p>
            </div>
            <div class="w-12 h-12 bg-govblue-50 text-govblue-800 rounded-xl flex items-center justify-center text-xl shadow-inner border border-govblue-100">
                <i class="fa-solid fa-list-check"></i>
            </div>
        </div>

        <!-- Participants Card -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-2">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Participants</p>
                <h3 class="text-3xl font-black text-gray-800">{{ number_format($totalParticipants) }}</h3>
                <p class="text-[10px] text-gray-400">Beneficiaries engaged in all sectors</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-800 rounded-xl flex items-center justify-center text-xl shadow-inner border border-emerald-100">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Events Card -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-2">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Events & Entries</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $totalEvents }}</h3>
                <p class="text-[10px] text-gray-400">Total actions recorded in the portal</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-800 rounded-xl flex items-center justify-center text-xl shadow-inner border border-purple-100">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Activity Chart -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Monthly Activity Flow (2026)</h4>
                <span class="text-[10px] text-gray-400 font-semibold uppercase">Events Count</span>
            </div>
            <div class="relative h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Category Distribution Chart -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Category-Wise Distribution</h4>
                <span class="text-[10px] text-gray-400 font-semibold uppercase">Structure Share</span>
            </div>
            <div class="relative h-64 flex justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Row (Recent Entries & Actions) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Entries Feed -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4 lg:col-span-2">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Recent Activity Logs</h4>
                <span class="text-[10px] text-gray-400 font-semibold uppercase">Latest Entries</span>
            </div>
            
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($recentEntries as $entry)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full {{ $entry['color'] }} text-white flex items-center justify-center ring-8 ring-white shadow-sm">
                                            <i class="fa-solid {{ $entry['icon'] }} text-xs"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-xs font-semibold text-gray-800">{{ $entry['title'] }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $entry['type'] }} • {{ $entry['date'] }}</p>
                                        </div>
                                        <div class="text-right text-xs whitespace-nowrap">
                                            <a href="{{ $entry['link'] }}" class="text-govblue-600 hover:text-govblue-800 font-bold hover:underline">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-6 text-center text-gray-400 text-xs">No recent actions recorded.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Quick Actions & Alerts Column -->
        <div class="space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4">
                <div class="border-b border-gray-100 pb-3">
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Quick actions</h4>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <!-- Create Event -->
                    <a href="{{ route('npc.create') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-govblue-50 border border-gray-100 hover:border-govblue-200 rounded-xl text-center transition-all group">
                        <span class="w-10 h-10 bg-govblue-900/10 text-govblue-900 rounded-full flex items-center justify-center text-lg mb-2 group-hover:scale-115 transition-transform duration-200">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        <span class="text-xs font-bold text-gray-800">Add NPC Entry</span>
                    </a>
                    
                    <!-- View Reports -->
                    <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-amber-50 border border-gray-100 hover:border-amber-200 rounded-xl text-center transition-all group">
                        <span class="w-10 h-10 bg-amber-500/10 text-amber-600 rounded-full flex items-center justify-center text-lg mb-2 group-hover:scale-115 transition-transform duration-200">
                            <i class="fa-solid fa-file-export"></i>
                        </span>
                        <span class="text-xs font-bold text-gray-800">Export Reports</span>
                    </a>

                    <!-- Open Gallery -->
                    <a href="{{ route('gallery.index') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 rounded-xl text-center transition-all group">
                        <span class="w-10 h-10 bg-emerald-500/10 text-emerald-600 rounded-full flex items-center justify-center text-lg mb-2 group-hover:scale-115 transition-transform duration-200">
                            <i class="fa-solid fa-images"></i>
                        </span>
                        <span class="text-xs font-bold text-gray-800">Open Gallery</span>
                    </a>

                    <!-- Manage Programs -->
                    <a href="{{ route('cmv.index') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-purple-50 border border-gray-100 hover:border-purple-200 rounded-xl text-center transition-all group">
                        <span class="w-10 h-10 bg-purple-500/10 text-purple-600 rounded-full flex items-center justify-center text-lg mb-2 group-hover:scale-115 transition-transform duration-200">
                            <i class="fa-solid fa-house-laptop"></i>
                        </span>
                        <span class="text-xs font-bold text-gray-800">Model Villages</span>
                    </a>
                </div>
            </div>

            <!-- Alerts / Notifications Peek -->
            <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">System Alerts</h4>
                    <a href="{{ route('notifications.index') }}" class="text-[10px] text-govblue-600 font-bold hover:underline">See All</a>
                </div>
                
                @php
                    $alerts = App\Models\Notification::latest()->take(3)->get();
                @endphp
                <div class="space-y-3">
                    @forelse($alerts as $alert)
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex gap-3 items-start">
                            <span class="w-2 h-2 rounded-full mt-1.5 {{ $alert->read ? 'bg-gray-300' : 'bg-rose-500' }} flex-shrink-0"></span>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800 leading-tight">{{ $alert->title }}</h5>
                                <p class="text-[10px] text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $alert->message }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 text-xs py-4">No active system alerts.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Monthly Activity Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyCounts = @json(array_values($monthlyCounts));
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Combined Events count',
                data: monthlyCounts,
                borderColor: '#1e3a8a',
                backgroundColor: 'rgba(30, 58, 138, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#3866ea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#9ca3af', font: { family: 'Outfit', size: 10 } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { color: '#9ca3af', font: { family: 'Outfit', size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Category Share Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($categoryData);
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                data: Object.values(categoryData),
                backgroundColor: [
                    '#f59e0b', // NPC (amber)
                    '#10b981', // CMV (emerald)
                    '#8b5cf6', // Mirror (purple)
                    '#3b82f6', // Video (blue)
                    '#6366f1', // Proposal (indigo)
                    '#0ea5e9', // 5S (sky)
                    '#ec4899', // Course (pink)
                    '#64748b'  // Training (slate)
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        padding: 10,
                        color: '#6b7280',
                        font: { family: 'Outfit', size: 9, weight: '500' }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // 3. Live Clock and Greeting Update
    function updateClock() {
        const now = new Date();
        
        // 1. Live Time
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
        const clockEl = document.getElementById('live-clock');
        if (clockEl) clockEl.innerText = timeString;

        // 2. Dynamic Greeting
        const currentHour = now.getHours();
        let greeting = 'Good Day';
        if (currentHour < 12) {
            greeting = 'Good Morning';
        } else if (currentHour < 17) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }
        const greetingEl = document.getElementById('live-greeting');
        if (greetingEl) greetingEl.innerText = greeting;

        // 3. Live Date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('en-US', options);
        const dateEl = document.getElementById('live-date');
        if (dateEl) dateEl.innerText = dateString;
    }

    // Run clock updates
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
