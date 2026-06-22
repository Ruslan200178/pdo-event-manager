<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter Report - {{ $letter->reference_number }}</title>
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
            <a href="{{ route('letters.show', $letter->id) }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-900 font-semibold">
                <i class="fa-solid fa-arrow-left"></i> Back to Details
            </a>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-govblue-900 text-white rounded-lg text-xs font-semibold hover:bg-govblue-955 transition-colors">
                    <i class="fa-solid fa-print"></i> Print Report
                </button>
                <a href="{{ route('letters.report.download', $letter->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700 transition-colors">
                    <i class="fa-solid fa-download"></i> Download PDF
                </a>
            </div>
        </div>

        <!-- Government Seal/Header -->
        <div class="text-center space-y-2 pb-6 border-b-2 border-gray-900">
            <h1 class="text-xl font-bold tracking-wider text-gray-900 uppercase text-center">National Productivity Secretariat</h1>
            <h2 class="text-base font-bold text-gray-800 uppercase text-center">District Secretariat - Trincomalee</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold text-center">Received Letter Correspondence Report</p>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 gap-4 py-6 text-xs text-gray-700">
            <div>
                <p><span class="font-bold">Reference Number:</span> {{ $letter->reference_number }}</p>
                <p class="mt-1"><span class="font-bold">Received Date:</span> {{ date('Y-m-d', strtotime($letter->date)) }}</p>
            </div>
            <div class="text-right">
                <p><span class="font-bold">Sender Institution:</span> {{ $letter->institution }}</p>
                <p class="mt-1"><span class="font-bold">Action Deadline:</span> 
                    @if($letter->deadline)
                        {{ date('Y-m-d', strtotime($letter->deadline)) }}
                    @else
                        None
                    @endif
                </p>
                <p class="mt-1"><span class="font-bold">Report Generated:</span> {{ date('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Details -->
        <div class="space-y-6 mt-4">
            <div>
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">1. Subject / Description</h3>
                <div class="text-xs text-gray-655 mt-3 leading-relaxed bg-gray-50 p-4 border border-gray-200 rounded-xl whitespace-pre-line">
                    {{ $letter->subject }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
