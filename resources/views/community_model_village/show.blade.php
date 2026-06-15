@extends('layouts.app')

@section('title', 'Model Village Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-lg uppercase tracking-wider">Community Model Village Program</span>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight mt-1">Village: {{ $village->village }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('cmv.index') }}" class="px-3.5 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>Back
            </a>
            <a href="{{ route('cmv.edit', $village->id) }}" class="px-3.5 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-pen"></i>Edit Entry
            </a>
        </div>
    </div>

    <!-- Data Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Key Metrics Panel -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-6 md:col-span-1">
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Financial Overview</h3>
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">

                </div>
                <div class="p-4 bg-emerald-50/50 border border-emerald-100 rounded-xl space-y-2">
                    <p class="text-[10px] text-emerald-600 font-bold uppercase">Spent Amount</p>
                    <p class="text-xl font-black text-emerald-900">LKR {{ number_format($village->amount, 2) }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Vote Number</p>
                        <p class="font-bold text-gray-850 truncate mt-0.5">{{ $village->vote_number }}</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Action Date</p>
                        <p class="font-bold text-gray-850 mt-0.5">{{ $village->date }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 border-t border-gray-100 pt-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Village Location</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-gray-500"><i class="fa-solid fa-map-location-dot text-xs"></i></span>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Division Name</p>
                            <p class="text-xs font-bold text-gray-800">{{ $village->division_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-gray-500"><i class="fa-solid fa-map-pin text-xs"></i></span>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">GN Division</p>
                            <p class="text-xs font-bold text-gray-800">{{ $village->gn_division }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seminar & Ceremony details -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-6 md:col-span-2">
            <!-- Objectives -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Objectives & Scope</h3>
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <p class="text-sm text-gray-750 leading-relaxed font-medium">{{ $village->purpose }}</p>
                </div>
            </div>

            <!-- Program timelines -->
            <div class="space-y-4 border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Awareness Seminars & Launch Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- General Awareness -->
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-bullhorn text-govblue-600"></i>Public Awareness</h4>
                        <div class="text-xs space-y-1 mt-3">
                            <p class="flex justify-between"><span class="text-gray-500">Conducted Date:</span> <span class="font-bold text-gray-800">{{ $village->awareness_date ?? 'Not Scheduled' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Public Attendance:</span> <span class="font-bold text-gray-800">{{ $village->participants_count }}</span></p>
                        </div>
                    </div>

                    <!-- Stakeholder Awareness -->
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-users-gear text-govblue-600"></i>Stakeholders Audit</h4>
                        <div class="text-xs space-y-1 mt-3">
                            <p class="flex justify-between"><span class="text-gray-500">Conducted Date:</span> <span class="font-bold text-gray-800">{{ $village->stakeholder_awareness_date ?? 'Not Scheduled' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Beneficiaries Registered:</span> <span class="font-bold text-gray-800">Yes</span></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Launching ceremony -->
                    <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl space-y-2">
                        <h4 class="text-xs font-bold text-blue-800 uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-rocket"></i>Launching Ceremony</h4>
                        <div class="text-xs space-y-1 mt-3">
                            <p class="flex justify-between"><span class="text-blue-600">Launching Date:</span> <span class="font-bold text-blue-900">{{ $village->launching_date ?? 'Not Conducted' }}</span></p>
                            <p class="flex justify-between"><span class="text-blue-600">Ceremony Attendees:</span> <span class="font-bold text-blue-900">{{ $village->ceremony_participants_count }}</span></p>
                        </div>
                    </div>

                    <!-- Staff Details -->
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5"><i class="fa-solid fa-user-check text-govblue-600"></i>Divisional Officer Assigned</h4>
                        <div class="text-xs space-y-1 mt-3">
                            <p class="flex justify-between"><span class="text-gray-500">Contact Officer:</span> <span class="font-bold text-gray-800 truncate" title="{{ $village->contacted_staff }}">{{ $village->contacted_staff }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Status:</span> <span class="font-bold text-emerald-600 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
