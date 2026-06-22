@extends('layouts.app')

@section('title', 'Past Archives')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Past Archives</h1>
            <p class="text-xs text-gray-500">Search, view, download, and catalog past productivity projects and reports.</p>
        </div>
        <div>
            <a href="{{ route('archive.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Archive Document</span>
            </a>
        </div>
    </div>

    <!-- Search/Filter Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4 md:p-6">
        <form action="{{ route('archive.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <!-- Year -->
            <div>
                <label for="year" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Filter by Year</label>
                <select name="year" id="year" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 bg-white">
                    <option value="">All Years</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <div>
                <label for="search" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Search</label>
                <input type="text" name="search" id="search" placeholder="Search titles, divisions..." value="{{ $search }}" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500">
            </div>

            <!-- Module -->
            <div>
                <label for="module_name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Program Module</label>
                <select name="module_name" id="module_name" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 bg-white">
                    <option value="">All Modules</option>
                    @foreach($modules as $m)
                        <option value="{{ $m }}" {{ $module == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span>Search</span>
                </button>
                @if($year || $search || $module)
                    <a href="{{ route('archive.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Year</th>
                            <th class="pb-3">DS Division</th>
                            <th class="pb-3">Module Name</th>
                            <th class="pb-3">Document Title</th>
                            <th class="pb-3">File Type</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($archives as $archive)
                            @php
                                $ext = strtolower(pathinfo($archive->file_path, PATHINFO_EXTENSION));
                                $isPdf = $ext === 'pdf';
                                $isExcel = in_array($ext, ['xls', 'xlsx']);
                                $isWord = in_array($ext, ['doc', 'docx']);
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-bold text-gray-800">{{ $archive->year }}</td>
                                <td class="py-3.5 text-gray-700 font-semibold">{{ $archive->division }}</td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-govblue-50 text-govblue-700 border border-govblue-100 text-[10px] font-bold uppercase">
                                        {{ $archive->module_name }}
                                    </span>
                                </td>
                                <td class="py-3.5 font-medium text-gray-800 max-w-xs truncate">{{ $archive->title }}</td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center gap-1">
                                        @if($isPdf)
                                            <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                                            <span class="text-gray-500 font-semibold text-[10px]">PDF</span>
                                        @elseif($isExcel)
                                            <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                                            <span class="text-gray-500 font-semibold text-[10px]">Excel</span>
                                        @elseif($isWord)
                                            <i class="fa-solid fa-file-word text-blue-500 text-sm"></i>
                                            <span class="text-gray-500 font-semibold text-[10px]">Word</span>
                                        @else
                                            <i class="fa-solid fa-file text-gray-400 text-sm"></i>
                                            <span class="text-gray-500 font-semibold text-[10px]">Doc</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('archive.download', $archive->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-[10px] font-bold transition-colors">
                                            <i class="fa-solid fa-download"></i>
                                            <span>Download</span>
                                        </a>
                                        <a href="{{ route('archive.show', $archive->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('archive.edit', $archive->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="{{ route('archive.destroy', $archive->id) }}" method="POST" onsubmit="return confirm('Delete this archived document?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-folder-open text-2xl mb-2 block text-gray-300"></i>
                                    No archive documents matched the search.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $archives->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
