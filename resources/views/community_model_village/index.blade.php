@extends('layouts.app')

@section('title', 'Community Model Village Program')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Community Model Village Programs</h1>
            <p class="text-xs text-gray-500">Manage district allocations, awareness seminars, village ceremonies, and development staff contacts.</p>
        </div>
        <div>
            <a href="{{ route('cmv.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                <i class="fa-solid fa-plus"></i>
                <span>Add CMV Entry</span>
            </a>
        </div>
    </div>

    @if (true)
        <div class="flex justify-between items-center mb-4">
            <form method="GET" action="{{ route('cmv.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Village or Vote Number" class="px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500" />
                <button type="submit" class="px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors">Search</button>
                @if(request('search'))
                    <a href="{{ route('cmv.index') }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-300 transition-colors">Clear</a>
                @endif
            </form>
        </div>
    @endif
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <!-- Tabs Header -->
        <div class="flex border-b border-gray-100 bg-gray-55/40 p-2 gap-2">
            <button onclick="switchTab('village-tab', ['division-tab'], this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-150 bg-govblue-900 text-white shadow-sm tab-btn">
                <i class="fa-solid fa-house-chimney mr-1.5"></i>
                <span>Model Village Entries</span>
            </button>
            <button onclick="switchTab('division-tab', ['village-tab'], this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all duration-150 tab-btn">
                <i class="fa-solid fa-diagram-project mr-1.5"></i>
                <span>Division-wise Summary</span>
            </button>
        </div>

        <!-- Village Tab Panel -->
        <div id="village-tab" class="tab-panel p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>

                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3">Village Name</th>
                            <th class="pb-3">Vote Number</th>
                            <th class="pb-3">Entry / Action Date</th>
                            <th class="pb-3">District Budget Allocation (LKR)</th>
                            <th class="pb-3">Amount Spent (LKR)</th>
                            <th class="pb-3">Purpose / Objective</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>

                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($villages as $village)
                            <tr class="hover:bg-gray-50/50 transition-colors">

                                <td class="py-3.5 pl-2">
                                    <span class="font-bold text-gray-950 block">{{ $village->village }}</span>
                                    <span class="text-[10px] text-gray-400 font-semibold block">{{ $village->gn_division }} • {{ $village->division_name }}</span>
                                </td>
                                <td class="py-3.5 font-semibold text-gray-800">{{ $village->vote_number }}</td>
                                <td class="py-3.5">{{ $village->date }}</td>
                                <td class="py-3.5 font-medium text-slate-500">{{ number_format($village->district_allocation, 2) }}</td>
                                <td class="py-3.5 font-bold text-slate-800">{{ number_format($village->amount, 2) }}</td>
                                <td class="py-3.5">{{ $village->purpose }}</td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('cmv.show', $village->id) }}" class="inline-flex items-center p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-900 rounded-lg transition-colors border border-gray-200" title="View Details">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                        </a>
                                        <a href="{{ route('cmv.edit', $village->id) }}" class="inline-flex items-center p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 hover:text-blue-900 rounded-lg transition-colors border border-blue-200" title="Edit">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </a>
                                        <form action="{{ route('cmv.destroy', $village->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this CMV entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-900 rounded-lg transition-colors border border-rose-200" title="Delete">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-house-chimney-window text-2xl mb-2 text-gray-300 block"></i>
                                    No community model villages recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($villages->hasPages())
                <div class="mt-4">
                    {{ $villages->links() }}
                </div>
            @endif
        </div>

        <!-- Division Tab Panel -->
        <div id="division-tab" class="tab-panel p-6 hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">DS Division</th>
                            <th class="pb-3">GN Division</th>
                            <th class="pb-3">Village Name</th>
                            <th class="pb-3">Staff Contact</th>
                            <th class="pb-3">Awareness Date</th>
                            <th class="pb-3">Stakeholder Date</th>
                            <th class="pb-3">Participants</th>
                            <th class="pb-3">Launching Date</th>
                            <th class="pb-3">Ceremony Participants</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($villagesAll as $v)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2">{{ $v->division_name }}</td>
                                <td class="py-3.5">{{ $v->gn_division }}</td>
                                <td class="py-3.5">{{ $v->village }}</td>
                                <td class="py-3.5 truncate max-w-[150px]" title="{{ $v->contacted_staff }}">{{ $v->contacted_staff }}</td>
                                <td class="py-3.5">{{ $v->awareness_date ?? '' }}</td>
                                <td class="py-3.5">{{ $v->stakeholder_awareness_date ? $v->stakeholder_awareness_date->format('Y-m-d') : '' }}</td>
                                <td class="py-3.5 text-center">{{ $v->participants_count }}</td>
                                <td class="py-3.5">{{ $v->launching_date ? $v->launching_date->format('Y-m-d') : '' }}</td>
                                <td class="py-3.5 text-center">{{ $v->ceremony_participants_count }}</td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('cmv.show', $v->id) }}" class="inline-flex items-center p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-900 rounded-lg transition-colors border border-gray-200" title="View Details">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                        </a>
                                        <a href="{{ route('cmv.edit', $v->id) }}" class="inline-flex items-center p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 hover:text-blue-900 rounded-lg transition-colors border border-blue-200" title="Edit">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </a>
                                        <form action="{{ route('cmv.destroy', $v->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this CMV entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-900 rounded-lg transition-colors border border-rose-200" title="Delete">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-diagram-project text-2xl mb-2 text-gray-300 block"></i>
                                    No division entries recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(activeId, inactiveIds, btnEl) {
        document.getElementById(activeId).classList.remove('hidden');
        inactiveIds.forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-govblue-900', 'text-white', 'shadow-sm');
            btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');
        });
        
        btnEl.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');
        btnEl.classList.add('bg-govblue-900', 'text-white', 'shadow-sm');
    }
</script>
@endsection
