@extends('layouts.app')

@section('title', 'ProYouth Selected Participants')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Selected Participants</h1>
            <p class="text-xs text-gray-500">View and manage evaluated participants and program winners separately by competition.</p>
        </div>
        <div>
            <a href="{{ route('proyouth.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Program</span>
            </a>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        @php
            $activeTab = request()->has('proposal_page') ? 'proposal' : 'video';
        @endphp
        <!-- Tabs Header -->
        <div class="flex border-b border-gray-100 bg-gray-55/40 p-2 gap-2">
            <button onclick="switchTab('video-tab', 'proposal-tab', this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-150 {{ $activeTab === 'video' ? 'bg-govblue-900 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} tab-btn">
                <i class="fa-solid fa-video mr-1.5"></i>
                <span>AI Video Competition</span>
            </button>
            <button onclick="switchTab('proposal-tab', 'video-tab', this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-semibold {{ $activeTab === 'proposal' ? 'bg-govblue-900 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-all duration-150 tab-btn">
                <i class="fa-solid fa-file-invoice mr-1.5"></i>
                <span>Project Proposal Competition</span>
            </button>
        </div>

        <!-- Video Tab Panel -->
        <div id="video-tab" class="tab-panel p-6 {{ $activeTab === 'video' ? '' : 'hidden' }}">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-base font-bold text-gray-800">AI Video Competition</h2>
                    <p class="text-[11px] text-gray-400">Selected participants for AI Video Competition</p>
                </div>
                <div>
                    <a href="{{ route('proyouth.report', ['type' => 'video']) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-govblue-900 text-white rounded-xl text-[11px] font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Report View</span>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Participant Name</th>
                            <th class="pb-3">NIC Number</th>
                            <th class="pb-3">DS Division</th>
                            <th class="pb-3">Institute / School</th>
                            <th class="pb-3">Marks</th>
                            <th class="pb-3">Winner Status</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($videoSelected as $item)
                            @php
                                $participant = $item->proyouth;
                            @endphp
                            @if($participant)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 pl-2 font-semibold text-gray-800">{{ $participant->name }}</td>
                                    <td class="py-3.5">{{ $participant->nic_number }}</td>
                                    <td class="py-3.5">{{ $participant->ds_division }}</td>
                                    <td class="py-3.5">{{ $participant->institute_school }}</td>
                                    <td class="py-3.5 font-bold text-gray-900">{{ $item->marks }}/100</td>
                                    <td class="py-3.5">
                                        @if($item->is_winner)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">
                                                <i class="fa-solid fa-trophy text-[9px]"></i>
                                                Winner
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-[10px]">Standard</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-right pr-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('proyouth.winner.toggle', ['type' => 'video', 'id' => $item->proyouth_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 text-[10px] font-bold rounded-lg border transition-colors {{ $item->is_winner ? 'bg-amber-50 text-amber-800 border-amber-250 hover:bg-amber-100' : 'bg-gray-50 text-gray-700 border-gray-250 hover:bg-gray-100' }}">
                                                    <i class="fa-solid fa-trophy mr-1"></i>
                                                    {{ $item->is_winner ? 'Remove Winner' : 'Make Winner' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('proyouth.marks.edit', ['type' => 'video', 'id' => $item->proyouth_id]) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-users-slash text-2xl mb-2 block text-gray-300"></i>
                                    No selected participants yet. Evaluate a participant to add them here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $videoSelected->appends(['proposal_page' => $proposalSelected->currentPage()])->links() }}
            </div>
        </div>

        <!-- Proposal Tab Panel -->
        <div id="proposal-tab" class="tab-panel p-6 {{ $activeTab === 'proposal' ? '' : 'hidden' }}">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Project Proposal Competition</h2>
                    <p class="text-[11px] text-gray-400">Selected participants for Project Proposal Competition</p>
                </div>
                <div>
                    <a href="{{ route('proyouth.report', ['type' => 'proposal']) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-govblue-900 text-white rounded-xl text-[11px] font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Report View</span>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Participant Name</th>
                            <th class="pb-3">NIC Number</th>
                            <th class="pb-3">DS Division</th>
                            <th class="pb-3">Institute / School</th>
                            <th class="pb-3">Marks</th>
                            <th class="pb-3">Winner Status</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($proposalSelected as $item)
                            @php
                                $participant = $item->proyouth;
                            @endphp
                            @if($participant)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 pl-2 font-semibold text-gray-800">{{ $participant->name }}</td>
                                    <td class="py-3.5">{{ $participant->nic_number }}</td>
                                    <td class="py-3.5">{{ $participant->ds_division }}</td>
                                    <td class="py-3.5">{{ $participant->institute_school }}</td>
                                    <td class="py-3.5 font-bold text-gray-900">{{ $item->marks }}/100</td>
                                    <td class="py-3.5">
                                        @if($item->is_winner)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">
                                                <i class="fa-solid fa-trophy text-[9px]"></i>
                                                Winner
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-[10px]">Standard</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-right pr-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('proyouth.winner.toggle', ['type' => 'proposal', 'id' => $item->proyouth_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 text-[10px] font-bold rounded-lg border transition-colors {{ $item->is_winner ? 'bg-amber-50 text-amber-800 border-amber-250 hover:bg-amber-100' : 'bg-gray-50 text-gray-700 border-gray-250 hover:bg-gray-100' }}">
                                                    <i class="fa-solid fa-trophy mr-1"></i>
                                                    {{ $item->is_winner ? 'Remove Winner' : 'Make Winner' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('proyouth.marks.edit', ['type' => 'proposal', 'id' => $item->proyouth_id]) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-users-slash text-2xl mb-2 block text-gray-300"></i>
                                    No selected participants yet. Evaluate a participant to add them here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $proposalSelected->appends(['video_page' => $videoSelected->currentPage()])->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(activeId, inactiveId, btnEl) {
        document.getElementById(activeId).classList.remove('hidden');
        document.getElementById(inactiveId).classList.add('hidden');
        
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-govblue-900', 'text-white', 'shadow-sm', 'font-bold');
            btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100', 'font-semibold');
        });
        
        btnEl.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100', 'font-semibold');
        btnEl.classList.add('bg-govblue-900', 'text-white', 'shadow-sm', 'font-bold');
    }
</script>
@endsection
