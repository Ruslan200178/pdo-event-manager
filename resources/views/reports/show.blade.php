@extends('layouts.app')

@section('title', 'View Generated Report')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $report->title }}</h1>
            <p class="text-xs text-gray-500">Showing compiled stats for the {{ $report->type }} cycle. Reporting Date: {{ $report->date }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-750 rounded-xl text-xs font-semibold hover:bg-gray-55 shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Reports</span>
            </a>
            <a href="{{ route('reports.pdf', $report->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Print PDF</span>
            </a>
            <a href="{{ route('reports.excel', $report->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-file-excel"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- Stats Summary Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm text-center">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide block">Productivity Programs</span>
            <span class="text-xl font-bold text-gray-800 block mt-1">
                {{ ($data['national_productivity_competitions_count'] ?? 0) + ($data['community_model_villages_count'] ?? 0) }}
            </span>
        </div>
        <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm text-center">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide block">Citizens Interviewed</span>
            <span class="text-xl font-bold text-gray-800 block mt-1">{{ $data['citizen_mirror_entries_count'] ?? 0 }}</span>
        </div>
        <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm text-center">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide block">Training Attendees</span>
            <span class="text-xl font-bold text-gray-800 block mt-1">{{ $data['training_participants_total'] ?? 0 }}</span>
        </div>
        <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm text-center">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wide block">5S certified units</span>
            <span class="text-xl font-bold text-emerald-600 block mt-1">{{ $data['five_s_certified_count'] ?? 0 }}</span>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Module Distribution Chart -->
        <div class="bg-white border border-gray-150 rounded-2xl p-6 shadow-sm">
            <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Module Entry Distribution</h3>
            <div class="h-64 relative">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>

        <!-- Productivity Summary Stats table -->
        <div class="bg-white border border-gray-150 rounded-2xl p-6 shadow-sm">
            <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Detailed Metrics Table</h3>
            <div class="overflow-y-auto max-h-64 text-xs">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 font-bold text-gray-400 uppercase tracking-wider text-[9px]">
                            <th class="pb-2">Metric description</th>
                            <th class="pb-2 text-right">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        <tr>
                            <td class="py-2">National Productivity Competitions (NPC)</td>
                            <td class="py-2 text-right font-bold">{{ $data['national_productivity_competitions_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Community Model Villages (CMV)</td>
                            <td class="py-2 text-right font-bold">{{ $data['community_model_villages_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Citizen Mirror Records</td>
                            <td class="py-2 text-right font-bold">{{ $data['citizen_mirror_entries_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">ProYouth AI Video Entries</td>
                            <td class="py-2 text-right font-bold">{{ $data['proyouth_videos_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">ProYouth Project Proposals</td>
                            <td class="py-2 text-right font-bold">{{ $data['proyouth_proposals_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">5S Certifications Total</td>
                            <td class="py-2 text-right font-bold">{{ $data['five_s_certifications_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Certification Courses</td>
                            <td class="py-2 text-right font-bold">{{ $data['certification_courses_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Total Students Enrolled</td>
                            <td class="py-2 text-right font-bold">{{ $data['total_students_enrolled'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Training Programs</td>
                            <td class="py-2 text-right font-bold">{{ $data['training_programs_count'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="py-2">Registered Productivity Officers</td>
                            <td class="py-2 text-right font-bold">{{ $data['registered_officers_count'] ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('distributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['NPC', 'CMV', 'Mirror', 'Video', 'Proposal', '5S', 'Course', 'Training'],
                datasets: [{
                    label: 'Entries count',
                    data: [
                        {{ $data['national_productivity_competitions_count'] ?? 0 }},
                        {{ $data['community_model_villages_count'] ?? 0 }},
                        {{ $data['citizen_mirror_entries_count'] ?? 0 }},
                        {{ $data['proyouth_videos_count'] ?? 0 }},
                        {{ $data['proyouth_proposals_count'] ?? 0 }},
                        {{ $data['five_s_certifications_count'] ?? 0 }},
                        {{ $data['certification_courses_count'] ?? 0 }},
                        {{ $data['training_programs_count'] ?? 0 }}
                    ],
                    backgroundColor: 'rgba(56, 102, 234, 0.8)',
                    borderColor: 'rgba(56, 102, 234, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
