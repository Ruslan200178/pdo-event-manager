<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPC Report - {{ $program->vote_number }}</title>
    <!-- Tailwind Compiled -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
            .print-card {
                border: 1px solid #e2e8f0;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 h-full py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 border border-gray-150 rounded-2xl shadow-sm print-card">
        
        <!-- Action buttons (Print / back) -->
        <div class="no-print flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
            <a href="{{ route('npc.show', $program->id) }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-900 font-semibold">
                <i class="fa-solid fa-arrow-left"></i> Back to Details
            </a>
                <div class="flex gap-2">
                    <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-govblue-900 text-white rounded-lg text-xs font-semibold hover:bg-govblue-950 transition-colors">
                        <i class="fa-solid fa-print"></i> Print Report
                    </button>
                    <a href="{{ route('npc.report.download', $program->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700 transition-colors">
                        <i class="fa-solid fa-download"></i> Download Report
                    </a>
                </div>
        </div>

        <!-- Government Seal/Header -->
        <div class="text-center space-y-2 pb-6 border-b-2 border-gray-900">
            <h1 class="text-xl font-bold tracking-wider text-gray-900 uppercase">National Productivity Secretariat</h1>
            <h2 class="text-base font-bold text-gray-800 uppercase">District Secretary</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">National Productivity Competition Evaluation Report</p>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 gap-4 py-6 text-xs text-gray-700">
            <div>
                <p><span class="font-bold">Vote Number:</span> {{ $program->vote_number }}</p>
                <p class="mt-1"><span class="font-bold">Conducted Date:</span> {{ $program->conducted_date }}</p>
                <p class="mt-1"><span class="font-bold">Venue / Place:</span> {{ $program->place }}</p>
            </div>
            <div class="text-right">
                <p><span class="font-bold">Allocation Amount:</span> LKR {{ number_format($program->amount, 2) }}</p>
                <p class="mt-1"><span class="font-bold">Received Allocation:</span> {{ $program->received_allocation }}</p>
                <p class="mt-1"><span class="font-bold">Report Generated:</span> {{ date('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Core Analysis Breakdown -->
        <div class="space-y-6 mt-4">
            
            <!-- Section: Participants -->
            <div>
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">1. Attendance & Participation Breakdown</h3>
                <table class="w-full text-left text-xs mt-3 border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 font-bold">
                            <th class="p-2 border-r border-gray-200">Sector</th>
                            <th class="p-2 text-right">Participants Count</th>
                            <th class="p-2 text-right">Share (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $total = $program->participants_public + $program->participants_school + $program->participants_private;
                            $publicPct = $total > 0 ? round(($program->participants_public / $total) * 100, 1) : 0;
                            $schoolPct = $total > 0 ? round(($program->participants_school / $total) * 100, 1) : 0;
                            $privatePct = $total > 0 ? round(($program->participants_private / $total) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td class="p-2 border-r border-gray-200">Public Sector Staff</td>
                            <td class="p-2 text-right">{{ $program->participants_public }}</td>
                            <td class="p-2 text-right">{{ $publicPct }}%</td>
                        </tr>
                        <tr>
                            <td class="p-2 border-r border-gray-200">School / Students Sector</td>
                            <td class="p-2 text-right">{{ $program->participants_school }}</td>
                            <td class="p-2 text-right">{{ $schoolPct }}%</td>
                        </tr>
                        <tr>
                            <td class="p-2 border-r border-gray-200">Private Sector Stakeholders</td>
                            <td class="p-2 text-right">{{ $program->participants_private }}</td>
                            <td class="p-2 text-right">{{ $privatePct }}%</td>
                        </tr>
                        <tr class="font-bold bg-gray-50">
                            <td class="p-2 border-r border-gray-200">Total Program Participants</td>
                            <td class="p-2 text-right">{{ $total }}</td>
                            <td class="p-2 text-right">100.0%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Section: Public Sector Statistics -->
            <div>
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">2. Public Sector Performance</h3>
                <div class="grid grid-cols-2 gap-4 mt-3 text-xs">
                    <div class="border border-gray-200 p-3">
                        <p class="font-semibold text-gray-600">Application Status</p>
                        <ul class="list-disc pl-4 mt-2 space-y-1">
                            <li>Total Applications Received: <span class="font-bold">{{ $program->public_applications_count }}</span></li>
                            <li>Selected for Evaluation: <span class="font-bold">{{ $program->public_selected_count }}</span></li>
                            <li>Selection Ratio: <span class="font-bold">
                                {{ $program->public_applications_count > 0 ? round(($program->public_selected_count / $program->public_applications_count) * 100, 1) : 0 }}%
                            </span></li>
                        </ul>
                    </div>
                    <div class="border border-gray-200 p-3">
                        <p class="font-semibold text-gray-600">Commentation Summary</p>
                        <ul class="list-disc pl-4 mt-2 space-y-1">
                            <li>Special Commentation Count: <span class="font-bold">{{ $program->special_commentation_count }}</span></li>
                            <li>Commentation Count: <span class="font-bold">{{ $program->commentation_count }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- School Sector Performance -->
            <div class="space-y-6 mt-6">
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">3. School Sector Performance</h3>
                <div class="grid grid-cols-2 gap-4 mt-3 text-xs">
                    <div class="border border-gray-200 p-3">
                        <p class="font-semibold text-gray-600">Application Status</p>
                        <ul class="list-disc pl-4 mt-2 space-y-1">
                            <li>Total Applications Received: <span class="font-bold">{{ $program->school_applications_count }}</span></li>
                            <li>Selected for Evaluation: <span class="font-bold">{{ $program->school_selected_count }}</span></li>
                            <li>Selection Ratio: <span class="font-bold">{{ $program->school_applications_count > 0 ? round(($program->school_selected_count / $program->school_applications_count) * 100, 1) : 0 }}%</span></li>
                        </ul>
                    </div>
                    <div class="border border-gray-200 p-3">
                        <p class="font-semibold text-gray-600">Commentation Summary</p>
                        <ul class="list-disc pl-4 mt-2 space-y-1">
                            <li>Special Commentation Count: <span class="font-bold">{{ $program->school_special_commentation_count }}</span></li>
                            <li>Commentation Count: <span class="font-bold">{{ $program->school_commentation_count }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Public Sector Placements -->
            <div class="mt-6">
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">4. Public Sector Placements & Awards</h3>
                <div class="grid grid-cols-3 gap-4 mt-3 text-xs text-center">
                    <div class="border border-gray-200 p-3 bg-amber-50/50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-amber-900 uppercase">1st Place</p>
                        <p class="text-xl font-bold mt-1 text-amber-950">{{ $program->place_1st_count }}</p>
                        @if(trim($program->public_place_1st_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->public_place_1st_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                    <div class="border border-gray-200 p-3 bg-slate-50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-gray-800 uppercase">2nd Place</p>
                        <p class="text-xl font-bold mt-1 text-gray-900">{{ $program->place_2nd_count }}</p>
                        @if(trim($program->public_place_2nd_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->public_place_2nd_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                    <div class="border border-gray-200 p-3 bg-orange-50/50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-orange-900 uppercase">3rd Place</p>
                        <p class="text-xl font-bold mt-1 text-orange-950">{{ $program->place_3rd_count }}</p>
                        @if(trim($program->public_place_3rd_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->public_place_3rd_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- School Sector Placements -->
            <div class="mt-6">
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">5. School Sector Placements & Awards</h3>
                <div class="grid grid-cols-3 gap-4 mt-3 text-xs text-center">
                    <div class="border border-gray-200 p-3 bg-amber-50/50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-amber-900 uppercase">1st Place</p>
                        <p class="text-xl font-bold mt-1 text-amber-950">{{ $program->school_place_1st_count }}</p>
                        @if(trim($program->school_place_1st_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->school_place_1st_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                    <div class="border border-gray-200 p-3 bg-slate-50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-gray-800 uppercase">2nd Place</p>
                        <p class="text-xl font-bold mt-1 text-gray-900">{{ $program->school_place_2nd_count }}</p>
                        @if(trim($program->school_place_2nd_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->school_place_2nd_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                    <div class="border border-gray-200 p-3 bg-orange-50/50 flex flex-col items-center">
                        <p class="font-bold text-[10px] text-orange-900 uppercase">3rd Place</p>
                        <p class="text-xl font-bold mt-1 text-orange-950">{{ $program->school_place_3rd_count }}</p>
                        @if(trim($program->school_place_3rd_institute))
                            <ul class="list-disc list-inside text-[10px] text-gray-500 mt-1 text-left w-full">
                                @foreach(array_filter(array_map('trim', explode(',', $program->school_place_3rd_institute))) as $inst)
                                    <li>{{ $inst }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1">N/A</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            
        </div>

    </div>
</body>
</html>
