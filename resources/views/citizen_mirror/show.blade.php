@extends('layouts.app')

@section('title', 'Citizen Mirror Entry Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Citizen Mirror Entry</h1>
            <p class="text-xs text-gray-500">View detailed information of this Citizen Mirror entry.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('citizen-mirror.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('citizen-mirror.edit', $entry->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Entry</span>
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $entry->title }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Created {{ $entry->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100">
                        <i class="fa-solid fa-users-viewfinder"></i>
                        <span>Citizen Mirror</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Division -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">DS Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $entry->division }}</span>
                </div>

                <!-- Date -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Conducted Date</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-regular fa-calendar-days text-gray-400 mr-1.5"></i>
                        {{ date('F d, Y', strtotime($entry->date)) }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Detailed Description / Summary</span>
                <div class="text-sm text-gray-650 mt-2 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line">
                    {{ $entry->description ?: 'No detailed summary provided.' }}
                </div>
            </div>

            <!-- Document Attachment -->
            @if($entry->document_path)
                <div class="border-t border-gray-100 pt-6">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Attached Document</span>
                    <div class="flex items-center justify-between p-3.5 bg-govblue-50/50 border border-govblue-100 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-govblue-100 flex items-center justify-center text-govblue-900 text-lg">
                                @if(Str::endsWith(strtolower($entry->document_path), '.pdf'))
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                @else
                                    <i class="fa-solid fa-file-image text-govblue-700"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">{{ basename($entry->document_path) }}</h5>
                                <p class="text-[10px] text-gray-400">Government Record Attachment</p>
                            </div>
                        </div>
                        <a href="{{ asset($entry->document_path) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-gray-250 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg shadow-sm transition-colors">
                            <i class="fa-solid fa-download text-gray-500"></i>
                            <span>Download File</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
