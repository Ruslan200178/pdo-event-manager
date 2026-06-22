<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocation Report - {{ $allocation->id }}</title>
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
            <a href="{{ route('fouri.allocations.show', $allocation->id) }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-900 font-semibold">
                <i class="fa-solid fa-arrow-left"></i> Back to Details
            </a>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-govblue-900 text-white rounded-lg text-xs font-semibold hover:bg-govblue-955 transition-colors">
                    <i class="fa-solid fa-print"></i> Print Report
                </button>
                <a href="{{ route('fouri.allocations.report.download', $allocation->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700 transition-colors">
                    <i class="fa-solid fa-download"></i> Download PDF
                </a>
            </div>
        </div>

        <!-- Government Seal/Header -->
        <div class="text-center space-y-2 pb-6 border-b-2 border-gray-900">
            <h1 class="text-xl font-bold tracking-wider text-gray-900 uppercase text-center">National Productivity Secretariat</h1>
            <h2 class="text-base font-bold text-gray-800 uppercase text-center">District Secretariat - Trincomalee</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold text-center">4i Project Initiative Allocation Report</p>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 gap-4 py-6 text-xs text-gray-700">
            <div>
                <p><span class="font-bold">Division:</span> {{ $allocation->division_name }}</p>
                <p class="mt-1"><span class="font-bold">Date:</span> {{ date('Y-m-d', strtotime($allocation->date)) }}</p>
                <p class="mt-1"><span class="font-bold">Program Type:</span> {{ $allocation->program_type }}</p>
            </div>
            <div class="text-right">
                <p><span class="font-bold">Amount:</span> LKR {{ number_format($allocation->amount, 2) }}</p>
                <p class="mt-1"><span class="font-bold">Participants:</span> {{ $allocation->participants_count }}</p>
                <p class="mt-1"><span class="font-bold">Report Generated:</span> {{ date('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Details -->
        <div class="space-y-6 mt-4">
            <div>
                <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider">1. Purpose of Allocation</h3>
                <div class="text-xs text-gray-650 mt-3 leading-relaxed whitespace-pre-line bg-gray-50 p-4 border border-gray-200 rounded-xl">
                    {{ $allocation->purpose }}
                </div>
            </div>

            @if($allocation->images && $allocation->images->count() > 0)
                <div>
                    <h3 class="text-xs font-bold text-gray-900 border-b border-gray-300 pb-1 uppercase tracking-wider mb-3">2. Event Gallery</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($allocation->images as $img)
                            <div class="rounded-xl overflow-hidden border border-gray-200 aspect-video bg-gray-50">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Allocation photo" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>
</body>
</html>
