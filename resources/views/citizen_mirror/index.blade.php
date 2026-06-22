@extends('layouts.app')

@section('title', 'Citizen Mirror')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Citizen Mirror Records</h1>
            <p class="text-xs text-gray-500">Document public feedback surveys, division audits, issues, and evaluations.</p>
        </div>
        <div>
            <a href="{{ route('citizen-mirror.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                <i class="fa-solid fa-plus"></i>
                <span>Add Record</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4">
        <form action="{{ route('citizen-mirror.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by title or division..." class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 transition-shadow">
            </div>
            <button type="submit" class="px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Search
            </button>
            @if(isset($search) && $search !== '')
                <a href="{{ route('citizen-mirror.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($entries as $entry)
            <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-[10px] font-bold rounded-lg uppercase">{{ $entry->division }}</span>
                        <span class="text-[10px] text-gray-400 font-semibold"><i class="fa-regular fa-clock mr-1"></i>{{ $entry->date }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base leading-snug line-clamp-1" title="{{ $entry->title }}">{{ $entry->title }}</h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed">{{ $entry->description }}</p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs">
                    <div>
                        @if($entry->document_path)
                            @php
                                $isPdf = str_ends_with(strtolower($entry->document_path), '.pdf');
                            @endphp
                            <span class="text-gray-400 font-semibold flex items-center gap-1">
                                <i class="fa-solid {{ $isPdf ? 'fa-file-pdf text-red-500' : 'fa-file-image text-blue-500' }} text-xs"></i>
                                Attachment Attached
                            </span>
                        @else
                            <span class="text-gray-400 italic">No attachments</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('citizen-mirror.show', $entry->id) }}" class="px-2.5 py-1.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-100 transition-colors">View</a>
                        <a href="{{ route('citizen-mirror.edit', $entry->id) }}" class="px-2.5 py-1.5 bg-white border border-gray-200 text-blue-700 font-bold rounded-lg hover:bg-blue-50 transition-colors">Edit</a>
                        <form action="{{ route('citizen-mirror.destroy', $entry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 rounded-lg transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-gray-400 bg-white border border-gray-150 rounded-2xl shadow-sm">
                <i class="fa-solid fa-users-viewfinder text-4xl mb-2 text-gray-200 block"></i>
                No Citizen Mirror records found.
            </div>
        @endforelse
    </div>

    @if($entries->hasPages())
        <div class="bg-white px-6 py-4 border border-gray-150 rounded-2xl shadow-sm">
            {{ $entries->links() }}
        </div>
    @endif
</div>
@endsection
