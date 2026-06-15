<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\NationalProductivityCompetition;
use App\Models\CommunityModelVillage;
use App\Models\CitizenMirror;
use App\Models\ProYouthVideo;
use App\Models\ProYouthProposal;
use App\Models\FiveSCertification;
use App\Models\CertificationCourse;
use App\Models\TrainingProgram;
use App\Models\Officer;
use App\Models\Notification;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Monthly,Quarterly,Annual',
            'date' => 'required|date',
        ]);

        // Gather statistics across all modules
        $stats = [
            'national_productivity_competitions_count' => NationalProductivityCompetition::count(),
            'community_model_villages_count' => CommunityModelVillage::count(),
            'citizen_mirror_entries_count' => CitizenMirror::count(),
            'proyouth_videos_count' => ProYouthVideo::count(),
            'proyouth_proposals_count' => ProYouthProposal::count(),
            'five_s_certifications_count' => FiveSCertification::count(),
            'five_s_certified_count' => FiveSCertification::where('status', 'Certified')->count(),
            'certification_courses_count' => CertificationCourse::count(),
            'total_students_enrolled' => CertificationCourse::sum('students_count'),
            'training_programs_count' => TrainingProgram::count(),
            'training_participants_total' => TrainingProgram::sum('participants_count'),
            'registered_officers_count' => Officer::count(),
        ];

        $report = Report::create([
            'title' => $request->title,
            'type' => $request->type,
            'date' => $request->date,
            'data_json' => json_encode($stats),
        ]);

        Notification::create([
            'title' => 'System Report Generated',
            'message' => "A new {$request->type} report titled '{$request->title}' was successfully generated.",
            'read' => false
        ]);

        return redirect()->route('reports.index')->with('success', 'Report generated successfully.');
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        $data = json_decode($report->data_json, true);
        return view('reports.show', compact('report', 'data'));
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->file_path && File::exists(public_path($report->file_path))) {
            File::delete(public_path($report->file_path));
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function downloadPdf($id)
    {
        $report = Report::findOrFail($id);
        $data = json_decode($report->data_json, true);
        return view('reports.pdf', compact('report', 'data'));
    }

    public function downloadExcel($id)
    {
        $report = Report::findOrFail($id);
        $data = json_decode($report->data_json, true);

        $filename = 'report_' . $report->id . '_' . time() . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($report, $data) {
            $file = fopen('php://output', 'w');

            // Header Row
            fputcsv($file, ['PDO PORTAL REPORT EXPORT']);
            fputcsv($file, ['Report Title', $report->title]);
            fputcsv($file, ['Report Type', $report->type]);
            fputcsv($file, ['Reporting Date', $report->date]);
            fputcsv($file, ['Generated At', $report->created_at->format('Y-m-d H:i:s')]);
            fputcsv($file, []); // Blank Row

            fputcsv($file, ['Module / Stat metric', 'Count / Value']);

            // Data Rows
            $rows = [
                'National Productivity Competitions Count' => $data['national_productivity_competitions_count'] ?? 0,
                'Community Model Villages Count' => $data['community_model_villages_count'] ?? 0,
                'Citizen Mirror Entries Count' => $data['citizen_mirror_entries_count'] ?? 0,
                'ProYouth AI Videos Count' => $data['proyouth_videos_count'] ?? 0,
                'ProYouth Project Proposals Count' => $data['proyouth_proposals_count'] ?? 0,
                '5S Certifications Count' => $data['five_s_certifications_count'] ?? 0,
                '5S Certified Count' => $data['five_s_certified_count'] ?? 0,
                'Certification Courses Count' => $data['certification_courses_count'] ?? 0,
                'Total Students Enrolled in Courses' => $data['total_students_enrolled'] ?? 0,
                'Training Programs Count' => $data['training_programs_count'] ?? 0,
                'Training Participants Total' => $data['training_participants_total'] ?? 0,
                'Registered Productivity Officers Count' => $data['registered_officers_count'] ?? 0,
            ];

            foreach ($rows as $metric => $val) {
                fputcsv($file, [$metric, $val]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
