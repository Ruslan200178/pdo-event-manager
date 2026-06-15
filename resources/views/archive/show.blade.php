@extends('layouts.app')

@section('title', 'Archived Document Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Archived Document Details</h1>
            <p class="text-xs text-gray-500">Divisional Secretariat productivity archives record view.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('archive.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-55 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('archive.edit', $archive->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Details</span>
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $archive->title }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Archived on {{ $archive->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100 uppercase">
                        {{ $archive->module_name }}
                    </span>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Calendar / Academic Year</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $archive->year }}</span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">DS Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $archive->division }}</span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Description / Abstract</span>
                <div class="text-sm text-gray-650 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line">
                    {{ $archive->description ?: 'No detailed abstract provided for this archived record.' }}
                </div>
            </div>

            <!-- Attachment -->
            @if($archive->file_path)
                @php
                    $ext = strtolower(pathinfo($archive->file_path, PATHINFO_EXTENSION));
                    $isPdf = $ext === 'pdf';
                    $isExcel = in_array($ext, ['xls', 'xlsx']);
                    $isWord = in_array($ext, ['doc', 'docx']);
                @endphp
                <div class="border-t border-gray-100 pt-6">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Archived File Attachment</span>
                    <div class="flex items-center justify-between p-3.5 bg-govblue-50/50 border border-govblue-100 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-govblue-100 flex items-center justify-center text-govblue-900 text-lg">
                                @if($isPdf)
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                @elseif($isExcel)
                                    <i class="fa-solid fa-file-excel text-emerald-600"></i>
                                @elseif($isWord)
                                    <i class="fa-solid fa-file-word text-blue-500"></i>
                                @else
                                    <i class="fa-solid fa-file text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-gray-800">{{ basename($archive->file_path) }}</h5>
                                <p class="text-[10px] text-gray-400">Archived Government Document ({{ strtoupper($ext) }})</p>
                            </div>
                        </div>
                        <a href="{{ route('archive.download', $archive->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-gray-250 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg shadow-sm transition-colors">
                            <i class="fa-solid fa-download text-gray-500"></i>
                            <span>Download Document</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
