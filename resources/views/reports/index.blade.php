@extends('layouts.app')

@section('title', 'Reports & Exports')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Reports & Statistics</h1>
            <p class="text-xs text-gray-500">Generate, view, and export aggregate statistics and division productivity progress reports.</p>
        </div>
    </div>

    <!-- Generate New Report Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-govblue-900"></i>
                <span>Generate Productivity Report</span>
            </h3>
            <form action="{{ route('reports.generate') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                @csrf
                <!-- Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-semibold text-gray-700 tracking-wide mb-1.5">Report Title / Description</label>
                    <input type="text" name="title" id="title" required placeholder="e.g. Q2 Productivity Progress Summary" value="{{ old('title') }}" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500">
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-xs font-semibold text-gray-700 tracking-wide mb-1.5">Reporting Cycle</label>
                    <select name="type" id="type" required class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-1 focus:ring-govblue-500">
                        <option value="Monthly">Monthly Report</option>
                        <option value="Quarterly">Quarterly Report</option>
                        <option value="Annual">Annual Report</option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-xs font-semibold text-gray-700 tracking-wide mb-1.5">Reporting Date</label>
                    <input type="date" name="date" id="date" required value="{{ old('date', date('Y-m-d')) }}" class="block w-full px-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500">
                </div>

                <!-- Generate button -->
                <div class="sm:col-span-4 flex justify-end mt-2 pt-4 border-t border-gray-50">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors">
                        <i class="fa-solid fa-gears"></i>
                        <span>Compile & Generate Report</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Saved Generated Reports</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Report Title</th>
                            <th class="pb-3">Type</th>
                            <th class="pb-3">Reporting Date</th>
                            <th class="pb-3">Compiled At</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($reports as $rep)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-bold text-gray-850">{{ $rep->title }}</td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $rep->type === 'Monthly' ? 'bg-blue-50 text-blue-700' : ($rep->type === 'Quarterly' ? 'bg-indigo-50 text-indigo-700' : 'bg-purple-50 text-purple-700') }}">
                                        {{ $rep->type }}
                                    </span>
                                </td>
                                <td class="py-3.5 font-medium text-gray-600">{{ $rep->date }}</td>
                                <td class="py-3.5 text-gray-450">{{ $rep->created_at->format('Y-m-d h:i A') }}</td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('reports.show', $rep->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-govblue-50 text-govblue-700 hover:bg-govblue-100 rounded-lg text-[10px] font-bold transition-colors">
                                            <i class="fa-solid fa-chart-column"></i>
                                            <span>View Charts</span>
                                        </a>
                                        <a href="{{ route('reports.pdf', $rep->id) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-[10px] font-bold transition-colors">
                                            <i class="fa-solid fa-file-pdf"></i>
                                            <span>Print PDF</span>
                                        </a>
                                        <a href="{{ route('reports.excel', $rep->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-[10px] font-bold transition-colors">
                                            <i class="fa-solid fa-file-excel"></i>
                                            <span>Export CSV</span>
                                        </a>
                                        <form action="{{ route('reports.destroy', $rep->id) }}" method="POST" onsubmit="return confirm('Permanently delete this compiled report?');">
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
                                <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-folder-open text-2xl mb-2 block text-gray-300"></i>
                                    No compiled reports found. Select parameters above to compile a new report.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
