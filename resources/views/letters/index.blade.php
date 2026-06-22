@extends('layouts.app')

@section('title', 'Received Letters')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Received Letters</h1>
            <p class="text-xs text-gray-500">Manage received letter correspondence and track deadlines.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('letters.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Letter</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-xs font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4">
        <form action="{{ route('letters.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search letters by reference number, institution, or subject..." class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 transition-shadow">
            </div>
            <button type="submit" class="px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Search
            </button>
            @if(isset($search) && $search !== '')
                <a href="{{ route('letters.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Letters Table Container -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Date</th>
                            <th class="pb-3">Reference Number</th>
                            <th class="pb-3">Institution</th>
                            <th class="pb-3">Subject</th>
                            <th class="pb-3">Deadline</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($letters as $letter)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-semibold text-gray-800 whitespace-nowrap">{{ $letter->date ?? '' }}</td>
                                <td class="py-3.5 font-semibold text-gray-700">{{ $letter->reference_number ?? '' }}</td>
                                <td class="py-3.5">{{ $letter->institution ?? '' }}</td>
                                <td class="py-3.5">{{ $letter->subject ?? '' }}</td>
                                <td class="py-3.5">
                                    @if($letter->deadline)
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-800 rounded-lg text-[10px] font-semibold">
                                            {{ $letter->deadline }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('letters.show', $letter->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('letters.edit', $letter->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('letters.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this letter record?');">
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
                                <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-envelope-open-text text-2xl mb-2 block text-gray-300"></i>
                                    No letters recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $letters->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
