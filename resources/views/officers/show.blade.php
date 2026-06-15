@extends('layouts.app')

@section('title', 'Officer Profile Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Officer Profile Details</h1>
            <p class="text-xs text-gray-500">Divisional Secretariat registration records of the Productivity Officer.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('officers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-55 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Grid</span>
            </a>
            <a href="{{ route('officers.edit', $officer->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Profile</span>
            </a>
        </div>
    </div>

    <!-- details Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row gap-6 pb-6 border-b border-gray-100 items-center sm:items-start text-center sm:text-left">
                <!-- Photo -->
                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-govblue-50 bg-gray-100 flex items-center justify-center flex-shrink-0 shadow-md">
                    @if($officer->photo_path)
                        <img src="{{ asset($officer->photo_path) }}" alt="{{ $officer->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user-tie text-gray-400 text-4xl"></i>
                    @endif
                </div>
                <div class="space-y-2">
                    <h2 class="text-xl font-bold text-gray-800">{{ $officer->name }}</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100">
                        <i class="fa-solid fa-user-tie"></i>
                        PDO Officer
                    </span>
                    <p class="text-xs text-gray-400">Registered on {{ $officer->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <!-- Parameters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Assigned DS Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $officer->division_name }}</span>
                </div>
                
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Divisional Secretariat</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $officer->divisional_secretariat ?: 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">NIC Number</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $officer->nic_number }}</span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Appointment Date</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-regular fa-calendar-days text-gray-400 mr-1"></i>
                        {{ date('F d, Y', strtotime($officer->appointment_date)) }}
                    </span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">District Rank</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $officer->district_rank ?: 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Progress Percentage</span>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-sm font-semibold text-gray-700">{{ !is_null($officer->progress_percentage) ? $officer->progress_percentage . '%' : 'N/A' }}</span>
                        @if(!is_null($officer->progress_percentage))
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden inline-block">
                                <div class="bg-govblue-600 h-2 rounded-full" style="width: {{ $officer->progress_percentage }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service history -->
            <div class="border-t border-gray-100 pt-6">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Service History / Responsibilities</span>
                <div class="text-sm text-gray-650 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line">
                    {{ $officer->service_details ?: 'No service details or history recorded.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
