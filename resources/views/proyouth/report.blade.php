<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProYouth Report - {{ $typeName }}</title>
    <!-- Tailwind Compiled -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
                font-size: 11pt;
            }
            .no-print {
                display: none;
            }
            .print-card {
                border: 1px solid #e2e8f0;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 h-full py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 border border-gray-150 rounded-2xl shadow-sm print-card">
        
        <!-- Action buttons (Print / back) -->
        <div class="no-print flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
            <a href="{{ route('proyouth.selected') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-900 font-semibold">
                <i class="fa-solid fa-arrow-left"></i> Back to Selected List
            </a>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-govblue-900 text-white rounded-lg text-xs font-semibold hover:bg-govblue-950 transition-colors">
                    <i class="fa-solid fa-print"></i> Print Report
                </button>
                <a href="{{ route('proyouth.report.download', ['type' => $type]) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700 transition-colors">
                    <i class="fa-solid fa-download"></i> Download Report
                </a>
            </div>
        </div>

        <!-- Government Seal/Header -->
        <div class="text-center space-y-2 pb-6 border-b-2 border-gray-900">
            <h1 class="text-xl font-bold tracking-wider text-gray-900 uppercase">District Secretariat - Trincomalee</h1>
            <h2 class="text-base font-bold text-gray-800 uppercase">ProYouth Program</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">{{ $typeName }} Selected Participants Report</p>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 gap-4 py-6 text-xs text-gray-700">
            <div>
                <p><span class="font-bold">Competition:</span> {{ $typeName }}</p>
                <p class="mt-1"><span class="font-bold">Program Name:</span> ProYouth Program</p>
            </div>
            <div class="text-right">
                <p><span class="font-bold">Total Selected Participants:</span> {{ count($selected) }}</p>
                <p class="mt-1"><span class="font-bold">Report Generated:</span> {{ date('Y-m-d H:i') }}</p>
            </div>
        </div>

        <!-- Content Table -->
        <div class="mt-4">
            <table class="w-full text-left text-xs border border-gray-200">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 font-bold text-gray-700 uppercase tracking-wider text-[10px]">
                        <th class="p-3 border-r border-gray-200">Participant Name</th>
                        <th class="p-3 border-r border-gray-200">NIC Number</th>
                        <th class="p-3 border-r border-gray-200 text-center">Age</th>
                        <th class="p-3 border-r border-gray-200">DS Division</th>
                        <th class="p-3 border-r border-gray-200">Institute / School</th>
                        <th class="p-3 border-r border-gray-200 text-center">Marks</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-650">
                    @forelse($selected as $item)
                        @php
                            $participant = $item->proyouth;
                        @endphp
                        @if($participant)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-3 border-r border-gray-200 font-semibold text-gray-800">{{ $participant->name }}</td>
                                <td class="p-3 border-r border-gray-200">{{ $participant->nic_number }}</td>
                                <td class="p-3 border-r border-gray-200 text-center">{{ $participant->age }}</td>
                                <td class="p-3 border-r border-gray-200">{{ $participant->ds_division }}</td>
                                <td class="p-3 border-r border-gray-200">{{ $participant->institute_school }}</td>
                                <td class="p-3 border-r border-gray-200 font-bold text-gray-900 text-center">{{ $item->marks }}/100</td>
                                <td class="p-3 text-center">
                                    @if($item->is_winner)
                                        <span class="font-bold text-amber-800 text-[10px]">WINNER</span>
                                    @else
                                        <span class="text-gray-400 text-[10px]">Selected</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                No selected participants found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Signature/Footer block for print -->
        <div class="mt-16 grid grid-cols-2 gap-8 text-xs pt-12 border-t border-gray-100">
            <div>
                <p class="border-t border-gray-400 pt-1 w-48 text-center font-semibold text-gray-650">Prepared By</p>
                <p class="text-gray-400 mt-1 text-[10px] text-center w-48">PDO Officer</p>
            </div>
            <div class="flex flex-col items-end">
                <p class="border-t border-gray-400 pt-1 w-48 text-center font-semibold text-gray-650">Approved By</p>
                <p class="text-gray-400 mt-1 text-[10px] text-center w-48">District Secretary / Representative</p>
            </div>
        </div>

    </div>
</body>
</html>
