<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProYouthVideo;
use App\Models\ProYouthProposal;
use App\Models\SelectedParticipant;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class ProYouthController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $videosQuery = ProYouthVideo::latest();
        $proposalsQuery = ProYouthProposal::latest();

        if ($search) {
            $videosQuery->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nic_number', 'like', '%' . $search . '%')
                  ->orWhere('ds_division', 'like', '%' . $search . '%');
            });

            $proposalsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nic_number', 'like', '%' . $search . '%')
                  ->orWhere('ds_division', 'like', '%' . $search . '%');
            });
        }

        $videos = $videosQuery->paginate(10, ['*'], 'videos_page')->appends(['search' => $search]);
        $proposals = $proposalsQuery->paginate(10, ['*'], 'proposals_page')->appends(['search' => $search]);

        return view('proyouth.index', compact('videos', 'proposals', 'search'));
    }

    // Video competition methods
    public function createVideo()
    {
        return view('proyouth.create_video');
    }

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'ds_division' => 'required|string|max:100',
            'institute_school' => 'required|string|max:255',
            'video_link' => 'nullable|url|max:255',
        ]);

        ProYouthVideo::create($validated);

        return redirect()->route('proyouth.index')->with('success', 'Video competition entry created successfully.');
    }

    public function editVideo($id)
    {
        $video = ProYouthVideo::findOrFail($id);
        return view('proyouth.edit_video', compact('video'));
    }

    public function updateVideo(Request $request, $id)
    {
        $video = ProYouthVideo::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'ds_division' => 'required|string|max:100',
            'institute_school' => 'required|string|max:255',
            'video_link' => 'nullable|url|max:255',
        ]);

        $video->update($validated);

        return redirect()->route('proyouth.index')->with('success', 'Video competition entry updated.');
    }

    public function destroyVideo($id)
    {
        $video = ProYouthVideo::findOrFail($id);
        // Delete selection if exists
        SelectedParticipant::where('proyouth_type', ProYouthVideo::class)->where('proyouth_id', $video->id)->delete();
        $video->delete();

        return redirect()->route('proyouth.index')->with('success', 'Video competition entry deleted.');
    }

    // Proposal competition methods
    public function createProposal()
    {
        return view('proyouth.create_proposal');
    }

    public function storeProposal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'ds_division' => 'required|string|max:100',
            'institute_school' => 'required|string|max:255',
            'proposal_link' => 'nullable|url|max:255',
        ]);

        ProYouthProposal::create($validated);

        return redirect()->route('proyouth.index')->with('success', 'Project proposal entry created successfully.');
    }

    public function editProposal($id)
    {
        $proposal = ProYouthProposal::findOrFail($id);
        return view('proyouth.edit_proposal', compact('proposal'));
    }

    public function updateProposal(Request $request, $id)
    {
        $proposal = ProYouthProposal::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'ds_division' => 'required|string|max:100',
            'institute_school' => 'required|string|max:255',
            'proposal_link' => 'nullable|url|max:255',
        ]);

        $proposal->update($validated);

        return redirect()->route('proyouth.index')->with('success', 'Project proposal entry updated.');
    }

    public function destroyProposal($id)
    {
        $proposal = ProYouthProposal::findOrFail($id);
        // Delete selection if exists
        SelectedParticipant::where('proyouth_type', ProYouthProposal::class)->where('proyouth_id', $proposal->id)->delete();
        $proposal->delete();

        return redirect()->route('proyouth.index')->with('success', 'Project proposal entry deleted.');
    }

    // Selection & Marks
    public function selectedList()
    {
        $videoSelected = SelectedParticipant::where('proyouth_type', ProYouthVideo::class)
            ->with('proyouth')
            ->latest()
            ->paginate(10, ['*'], 'video_page');

        $proposalSelected = SelectedParticipant::where('proyouth_type', ProYouthProposal::class)
            ->with('proyouth')
            ->latest()
            ->paginate(10, ['*'], 'proposal_page');

        return view('proyouth.selected', compact('videoSelected', 'proposalSelected'));
    }

    public function editMarks($type, $id)
    {
        // $type can be 'video' or 'proposal'
        $modelClass = $type === 'video' ? ProYouthVideo::class : ProYouthProposal::class;
        $participant = $modelClass::findOrFail($id);

        $selection = SelectedParticipant::where('proyouth_type', $modelClass)
            ->where('proyouth_id', $id)
            ->first();

        $marks = $selection ? $selection->marks : 0;

        return view('proyouth.marks', compact('participant', 'type', 'id', 'marks'));
    }

    public function updateMarks(Request $request, $type, $id)
    {
        $request->validate([
            'marks' => 'required|integer|min:0|max:100',
        ]);

        $modelClass = $type === 'video' ? ProYouthVideo::class : ProYouthProposal::class;
        $participant = $modelClass::findOrFail($id);

        $selection = SelectedParticipant::updateOrCreate(
            [
                'proyouth_type' => $modelClass,
                'proyouth_id' => $id,
            ],
            [
                'marks' => $request->marks,
            ]
        );

        // Auto notification if high score or selected
        Notification::create([
            'title' => 'Participant Selected & Evaluated',
            'message' => "Participant {$participant->name} in ProYouth {$type} competition has been evaluated with marks: {$request->marks}.",
            'read' => false
        ]);

        return redirect()->route('proyouth.selected')->with('success', 'Marks saved successfully.');
    }

    public function toggleWinner($type, $id)
    {
        $modelClass = $type === 'video' ? ProYouthVideo::class : ProYouthProposal::class;
        $selection = SelectedParticipant::where('proyouth_type', $modelClass)
            ->where('proyouth_id', $id)
            ->firstOrFail();

        $selection->is_winner = !$selection->is_winner;
        $selection->save();

        $status = $selection->is_winner ? 'Winner' : 'Regular Participant';

        // Notify
        Notification::create([
            'title' => 'Winner Status Updated',
            'message' => "Participant status updated to {$status}.",
            'read' => false
        ]);

        return redirect()->back()->with('success', "Participant winner status updated to: " . ($selection->is_winner ? 'Winner' : 'Standard') . ".");
    }

    public function report($type)
    {
        if ($type !== 'video' && $type !== 'proposal') {
            abort(404);
        }

        $modelClass = $type === 'video' ? ProYouthVideo::class : ProYouthProposal::class;
        $typeName = $type === 'video' ? 'AI Video Competition' : 'Project Proposal Competition';

        $selected = SelectedParticipant::where('proyouth_type', $modelClass)
            ->with('proyouth')
            ->latest()
            ->get();

        return view('proyouth.report', compact('selected', 'type', 'typeName'));
    }

    public function downloadReport($type)
    {
        if ($type !== 'video' && $type !== 'proposal') {
            abort(404);
        }

        ini_set('max_execution_time', 300);
        set_time_limit(300);

        $modelClass = $type === 'video' ? ProYouthVideo::class : ProYouthProposal::class;
        $typeName = $type === 'video' ? 'AI Video Competition' : 'Project Proposal Competition';

        $selected = SelectedParticipant::where('proyouth_type', $modelClass)
            ->with('proyouth')
            ->latest()
            ->get();

        $fileName = 'proyouth_report_' . $type . '_' . date('Ymd_His') . '.pdf';
        $storagePath = storage_path('app/public/reports/' . $fileName);

        $pdf = Pdf::loadView('proyouth.report_pdf', compact('selected', 'type', 'typeName'));

        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }
        $pdf->save($storagePath);

        return response()->download($storagePath, $fileName);
    }
}
