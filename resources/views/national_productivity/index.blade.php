@extends('layouts.app')

@section('title', 'National Productivity Competition')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">National Productivity Competition (Criteria Programs)</h1>
            <p class="text-xs text-gray-500">Manage received allocations, vote numbers, participant divisions, and application statistics.</p>
        </div>
        <div>
            <a href="{{ route('npc.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                <i class="fa-solid fa-plus"></i>
                <span>Add NPC Program</span>
            </a>
        </div>
    </div>

    <!-- Search/Filter Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4 md:p-6">
        <form action="{{ route('npc.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <!-- Vote Number -->
            <div>
                <label for="vote_number" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Vote Number</label>
                <input type="text" name="vote_number" id="vote_number" placeholder="Search vote number..." value="{{ $voteNumber }}" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500">
            </div>

            <!-- Place / Location -->
            <div>
                <label for="place" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Place / Location</label>
                <input type="text" name="place" id="place" placeholder="Search place..." value="{{ $place }}" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500">
            </div>

            <!-- Received Allocation -->
            <div>
                <label for="received_allocation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Received Allocation</label>
                <select name="received_allocation" id="received_allocation" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 bg-white">
                    <option value="">All</option>
                    <option value="Yes" {{ $receivedAllocation == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ $receivedAllocation == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span>Search</span>
                </button>
                @if($voteNumber || $place || $receivedAllocation)
                    <a href="{{ route('npc.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-55 text-gray-750 rounded-xl text-xs font-semibold shadow-sm flex items-center justify-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-150 text-xs text-gray-500 font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Vote Number</th>
                        <th class="px-6 py-4">Conducted Date</th>
                        <th class="px-6 py-4">Place / Location</th>
                        <th class="px-6 py-4">Amount (LKR)</th>
                        <th class="px-6 py-4">Participants</th>
                        <th class="px-6 py-4">Selected Apps</th>
                        <th class="px-6 py-4">Photos</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($programs as $program)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $program->vote_number }}</td>
                            <td class="px-6 py-4">{{ $program->conducted_date }}</td>
                            <td class="px-6 py-4 max-w-xs truncate">{{ $program->place }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ number_format($program->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-lg">
                                    <i class="fa-solid fa-users text-[10px]"></i>
                                    {{ $program->participants_public + $program->participants_school + $program->participants_private }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-emerald-600">{{ $program->public_selected_count }} / {{ $program->public_applications_count }}</td>
                            <td class="px-6 py-4">
                                @if(count($program->galleryImages) > 0)
                                    <a href="{{ route('npc.show', $program->id) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-govblue-50 hover:bg-govblue-100 text-govblue-700 hover:text-govblue-900 text-xs font-bold rounded-lg border border-govblue-150 transition-colors" title="View Photos">
                                        <i class="fa-solid fa-images text-[10px]"></i>
                                        <span>{{ count($program->galleryImages) }} Photos</span>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 font-normal italic">No photos</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('npc.show', $program->id) }}" class="inline-flex items-center p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-900 rounded-lg transition-colors border border-gray-200" title="View Details">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('npc.report', $program->id) }}" class="inline-flex items-center p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 hover:text-amber-900 rounded-lg transition-colors border border-amber-200" title="Detailed Analysis Report">
                                    <i class="fa-solid fa-file-invoice text-xs"></i>
                                </a>
                                <a href="{{ route('npc.edit', $program->id) }}" class="inline-flex items-center p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 hover:text-blue-900 rounded-lg transition-colors border border-blue-200" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('npc.destroy', $program->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this program?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-900 rounded-lg transition-colors border border-rose-200" title="Delete">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400 text-xs">
                                <i class="fa-solid fa-award text-3xl mb-2 text-gray-200 block"></i>
                                No NPC criteria programs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($programs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-150">
                {{ $programs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
