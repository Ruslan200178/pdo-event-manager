@extends('layouts.app')

@section('title', 'ProYouth Program')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">ProYouth Program</h1>
            <p class="text-xs text-gray-500">Manage AI Video and Project Proposal Competitions for youth productivity development.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('proyouth.selected') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-list-check"></i>
                <span>View Selected List</span>
            </a>
            <a href="{{ route('proyouth.video.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Video Entry</span>
            </a>
            <a href="{{ route('proyouth.proposal.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Proposal Entry</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4">
        <form action="{{ route('proyouth.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name, NIC, or division..." class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 transition-shadow">
            </div>
            <button type="submit" class="px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Search
            </button>
            @if(isset($search) && $search !== '')
                <a href="{{ route('proyouth.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Tabs Container -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <!-- Tabs Header -->
        <div class="flex border-b border-gray-100 bg-gray-55/40 p-2 gap-2">
            <button onclick="switchTab('video-tab', 'proposal-tab', this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-150 bg-govblue-900 text-white shadow-sm tab-btn">
                <i class="fa-solid fa-video mr-1.5"></i>
                <span>AI Video Competition</span>
            </button>
            <button onclick="switchTab('proposal-tab', 'video-tab', this)" class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all duration-150 tab-btn">
                <i class="fa-solid fa-file-invoice mr-1.5"></i>
                <span>Project Proposal Competition</span>
            </button>
        </div>

        <!-- Video Tab Panel -->
        <div id="video-tab" class="tab-panel p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Name</th>
                            <th class="pb-3">NIC</th>
                            <th class="pb-3">Age</th>
                            <th class="pb-3">DS Division</th>
                            <th class="pb-3">Institute / School</th>
                            <th class="pb-3">Link</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($videos as $video)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-semibold text-gray-800">{{ $video->name }}</td>
                                <td class="py-3.5">{{ $video->nic_number }}</td>
                                <td class="py-3.5">{{ $video->age }}</td>
                                <td class="py-3.5">{{ $video->ds_division }}</td>
                                <td class="py-3.5">{{ $video->institute_school }}</td>
                                <td class="py-3.5">
                                    @if($video->video_link)
                                        <a href="{{ $video->video_link }}" target="_blank" class="inline-flex items-center gap-1 text-govblue-600 hover:underline font-semibold">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            <span>Link</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('proyouth.marks.edit', ['type' => 'video', 'id' => $video->id]) }}" class="px-2.5 py-1 bg-govblue-50 text-govblue-700 hover:bg-govblue-100 rounded-lg font-bold text-[10px] transition-colors">
                                            Evaluate
                                        </a>
                                        <a href="{{ route('proyouth.video.edit', $video->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('proyouth.video.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-video-slash text-2xl mb-2 block text-gray-300"></i>
                                    No video entries recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $videos->appends(['proposals_page' => $proposals->currentPage()])->links() }}
            </div>
        </div>

        <!-- Proposal Tab Panel -->
        <div id="proposal-tab" class="tab-panel p-6 hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Name</th>
                            <th class="pb-3">NIC</th>
                            <th class="pb-3">Age</th>
                            <th class="pb-3">DS Division</th>
                            <th class="pb-3">Institute / School</th>
                            <th class="pb-3">Link</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($proposals as $proposal)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-semibold text-gray-800">{{ $proposal->name }}</td>
                                <td class="py-3.5">{{ $proposal->nic_number }}</td>
                                <td class="py-3.5">{{ $proposal->age }}</td>
                                <td class="py-3.5">{{ $proposal->ds_division }}</td>
                                <td class="py-3.5">{{ $proposal->institute_school }}</td>
                                <td class="py-3.5">
                                    @if($proposal->proposal_link)
                                        <a href="{{ $proposal->proposal_link }}" target="_blank" class="inline-flex items-center gap-1 text-govblue-600 hover:underline font-semibold">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            <span>Link</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('proyouth.marks.edit', ['type' => 'proposal', 'id' => $proposal->id]) }}" class="px-2.5 py-1 bg-govblue-50 text-govblue-700 hover:bg-govblue-100 rounded-lg font-bold text-[10px] transition-colors">
                                            Evaluate
                                        </a>
                                        <a href="{{ route('proyouth.proposal.edit', $proposal->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('proyouth.proposal.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this proposal entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-file-invoice text-2xl mb-2 block text-gray-300"></i>
                                    No project proposal entries recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $proposals->appends(['videos_page' => $videos->currentPage()])->links() }}
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
            btn.classList.remove('bg-govblue-900', 'text-white', 'shadow-sm');
            btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');
        });
        
        btnEl.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-100');
        btnEl.classList.add('bg-govblue-900', 'text-white', 'shadow-sm');
    }
</script>
@endsection
