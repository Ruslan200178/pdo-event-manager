@extends('layouts.app')

@section('title', 'Letter Details')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Letter Details</h1>
            <p class="text-xs text-gray-500 mt-1">Detailed record of received letter correspondence.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('letters.report', $letter->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Report View</span>
            </a>
            <a href="{{ route('letters.edit', $letter->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-955 shadow-sm transition-colors">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Letter</span>
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Letter Reference</h2>
                    <p class="text-sm font-bold text-govblue-900 mt-1">{{ $letter->reference_number }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-100">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <span>Received Letter</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Received Date -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Received Date</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-regular fa-calendar-days text-gray-455 mr-1.5"></i>
                        {{ date('F d, Y', strtotime($letter->date)) }}
                    </span>
                </div>

                <!-- Institution -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sender Institution / Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-solid fa-building text-gray-450 mr-1.5"></i>
                        {{ $letter->institution }}
                    </span>
                </div>

                <!-- Subject -->
                <div class="md:col-span-2">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subject</span>
                    <span class="text-sm font-semibold text-gray-800 block mt-1 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100">{{ $letter->subject }}</span>
                </div>

                <!-- Deadline -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Action Deadline</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        @if($letter->deadline)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 rounded-lg text-xs font-bold border border-rose-100">
                                <i class="fa-regular fa-clock text-rose-550 mr-1"></i>
                                {{ date('F d, Y', strtotime($letter->deadline)) }}
                            </span>
                        @else
                            <span class="text-gray-400 italic">No deadline set</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
