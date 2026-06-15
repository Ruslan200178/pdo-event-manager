<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NationalProductivityCompetition;
use App\Models\CommunityModelVillage;
use App\Models\CitizenMirror;
use App\Models\ProYouthVideo;
use App\Models\ProYouthProposal;
use App\Models\FiveSCertification;
use App\Models\CertificationCourse;
use App\Models\TrainingProgram;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate KPI Counts
        $npcCount = NationalProductivityCompetition::count();
        $cmvCount = CommunityModelVillage::count();
        $trainingCount = TrainingProgram::count();
        $fivesCount = FiveSCertification::count();
        $courseCount = CertificationCourse::count();
        $mirrorCount = CitizenMirror::count();
        
        $totalPrograms = $npcCount + $cmvCount + $trainingCount + $fivesCount + $courseCount;
        $totalEvents = $npcCount + $cmvCount + $trainingCount + $fivesCount + $courseCount + $mirrorCount;

        // Calculate Total Participants
        $npcParticipants = NationalProductivityCompetition::sum(DB::raw('participants_public + participants_school + participants_private'));
        $cmvParticipants = CommunityModelVillage::sum(DB::raw('participants_count + ceremony_participants_count'));
        $trainingParticipants = TrainingProgram::sum('participants_count');
        $fivesParticipants = FiveSCertification::sum('participants_count');
        $courseParticipants = CertificationCourse::sum('students_count');

        $totalParticipants = $npcParticipants + $cmvParticipants + $trainingParticipants + $fivesParticipants + $courseParticipants;

        // 2. Fetch Recent Activities (Polymorphic-like display from multiple models)
        $activities = collect([]);

        // NPC
        NationalProductivityCompetition::latest()->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'National Productivity Competition',
                'title' => 'NPC program conducted at ' . $item->place,
                'date' => $item->conducted_date,
                'icon' => 'fa-award',
                'color' => 'bg-amber-500',
                'link' => route('npc.show', $item->id),
                'created_at' => $item->created_at
            ]);
        });

        // CMV
        CommunityModelVillage::latest()->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'Model Village Program',
                'title' => 'CMV Village event in ' . $item->village,
                'date' => $item->date,
                'icon' => 'fa-house-chimney-window',
                'color' => 'bg-emerald-500',
                'link' => route('cmv.show', $item->id),
                'created_at' => $item->created_at
            ]);
        });

        // Citizen Mirror
        CitizenMirror::latest()->take(3)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'Citizen Mirror',
                'title' => 'Citizen Mirror entry: ' . $item->title,
                'date' => $item->date,
                'icon' => 'fa-users-viewfinder',
                'color' => 'bg-purple-500',
                'link' => route('citizen-mirror.show', $item->id),
                'created_at' => $item->created_at
            ]);
        });

        // ProYouth
        ProYouthVideo::latest()->take(2)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'ProYouth Video',
                'title' => 'AI Video entry submitted by ' . $item->name,
                'date' => $item->created_at->format('Y-m-d'),
                'icon' => 'fa-video',
                'color' => 'bg-blue-500',
                'link' => route('proyouth.index'),
                'created_at' => $item->created_at
            ]);
        });

        // 5S
        FiveSCertification::latest()->take(2)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => '5S Certification',
                'title' => '5S Certification program: ' . $item->program_name,
                'date' => $item->date,
                'icon' => 'fa-certificate',
                'color' => 'bg-sky-500',
                'link' => route('five-s.show', $item->id),
                'created_at' => $item->created_at
            ]);
        });

        // Training
        TrainingProgram::latest()->take(2)->get()->each(function ($item) use ($activities) {
            $activities->push([
                'type' => 'Training Program',
                'title' => 'Training program at ' . $item->institution,
                'date' => $item->date,
                'icon' => 'fa-chalkboard-user',
                'color' => 'bg-indigo-500',
                'link' => route('training.show', $item->id),
                'created_at' => $item->created_at
            ]);
        });

        // Sort all by created_at and take the top 8
        $recentEntries = $activities->sortByDesc('created_at')->take(8);

        // 3. Prepare Charts Data
        // Category Distribution Chart
        $categoryData = [
            'National Productivity' => $npcCount,
            'Model Village' => $cmvCount,
            'Citizen Mirror' => $mirrorCount,
            'ProYouth Video' => ProYouthVideo::count(),
            'ProYouth Proposal' => ProYouthProposal::count(),
            '5S Certification' => $fivesCount,
            'Certification Course' => $courseCount,
            'Training Program' => $trainingCount,
        ];

        // Monthly activity distribution (aggregate dates in the current year, e.g. 2026)
        $monthlyCounts = array_fill(1, 12, 0);
        $currentYear = 2026;

        $npcMonths = NationalProductivityCompetition::whereYear('conducted_date', $currentYear)
            ->select(DB::raw('MONTH(conducted_date) as month, count(*) as count'))
            ->groupBy('month')->pluck('count', 'month');

        $cmvMonths = CommunityModelVillage::whereYear('date', $currentYear)
            ->select(DB::raw('MONTH(date) as month, count(*) as count'))
            ->groupBy('month')->pluck('count', 'month');

        $fivesMonths = FiveSCertification::whereYear('date', $currentYear)
            ->select(DB::raw('MONTH(date) as month, count(*) as count'))
            ->groupBy('month')->pluck('count', 'month');

        $trainingMonths = TrainingProgram::whereYear('date', $currentYear)
            ->select(DB::raw('MONTH(date) as month, count(*) as count'))
            ->groupBy('month')->pluck('count', 'month');

        foreach (range(1, 12) as $m) {
            $monthlyCounts[$m] = ($npcMonths[$m] ?? 0) 
                               + ($cmvMonths[$m] ?? 0) 
                               + ($fivesMonths[$m] ?? 0) 
                               + ($trainingMonths[$m] ?? 0);
        }

        return view('dashboard', compact(
            'totalPrograms',
            'totalParticipants',
            'totalEvents',
            'recentEntries',
            'categoryData',
            'monthlyCounts'
        ));
    }
}
