@extends('layouts.app')

@section('title', '5S Certification Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">5S Program Details</h1>
            <p class="text-xs text-gray-500">View logged information regarding this 5S workspace certification program.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('five-s.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('five-s.edit', $record->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Record</span>
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $record->program_name }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Audit conducted on {{ date('M d, Y', strtotime($record->date)) }}</p>
                </div>
                <div>
                    @if($record->status === 'Certified')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-100 text-xs font-bold rounded-full">
                            <i class="fa-solid fa-circle-check"></i>
                            Certified
                        </span>
                    @elseif($record->status === 'Pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-100 text-xs font-bold rounded-full">
                            <i class="fa-solid fa-clock"></i>
                            Pending Audit
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-800 border border-rose-100 text-xs font-bold rounded-full">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Rejected
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Institution -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Institution / Office</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $record->institution }}</span>
                </div>

                <!-- Division -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">DS Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $record->division }}</span>
                </div>

                <!-- Participants -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Participants Count</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $record->participants_count }}</span>
                </div>
            </div>

            <!-- Attachment -->
            @if($record->document_path)
                <div class="border-t border-gray-100 pt-6">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Audit Report Document</span>
                    <div class="flex items-center justify-between p-3.5 bg-govblue-50/50 border border-govblue-100 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-govblue-100 flex items-center justify-center text-govblue-900 text-lg">
                                @if(Str::endsWith(strtolower($record->document_path), '.pdf'))
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                @else
                                    <i class="fa-solid fa-file-image text-govblue-700"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">{{ basename($record->document_path) }}</h5>
                                <p class="text-[10px] text-gray-400">5S Certification Document</p>
                            </div>
                        </div>
                        <a href="{{ asset($record->document_path) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-gray-250 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg shadow-sm transition-colors">
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
