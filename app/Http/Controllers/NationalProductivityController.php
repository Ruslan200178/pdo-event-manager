<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NationalProductivityCompetition;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class NationalProductivityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = NationalProductivityCompetition::latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('vote_number', 'like', '%' . $search . '%')
                  ->orWhere('place', 'like', '%' . $search . '%')
                  ->orWhere('program_name', 'like', '%' . $search . '%');
            });
        }

        $programs = $query->paginate(10)->appends(['search' => $search]);
        return view('national_productivity.index', compact('programs', 'search'));
    }

    public function create()
    {
        return view('national_productivity.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'received_allocation' => 'required|string',
            'vote_number' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'conducted_date' => 'required|date',
            'place' => 'required|string|max:255',
            'participants_public' => 'required|integer|min:0',
            'participants_school' => 'required|integer|min:0',
            'participants_private' => 'required|integer|min:0',
            'public_applications_count' => 'required|integer|min:0',
            'public_selected_count' => 'required|integer|min:0',
            'place_1st_count' => 'required|integer|min:0',
            'place_2nd_count' => 'required|integer|min:0',
            'place_3rd_count' => 'required|integer|min:0',
            'special_commentation_count' => 'required|integer|min:0',
            'commentation_count' => 'required|integer|min:0',
            'school_applications_count' => 'required|integer|min:0',
            'school_selected_count' => 'required|integer|min:0',
            'school_place_1st_count' => 'required|integer|min:0',
            'school_place_2nd_count' => 'required|integer|min:0',
            'school_place_3rd_count' => 'required|integer|min:0',
            'school_special_commentation_count' => 'required|integer|min:0',
            'school_commentation_count' => 'required|integer|min:0',
            'public_place_1st_institutes' => 'nullable|array',
            'public_place_2nd_institutes' => 'nullable|array',
            'public_place_3rd_institutes' => 'nullable|array',
            'school_place_1st_institutes' => 'nullable|array',
            'school_place_2nd_institutes' => 'nullable|array',
            'school_place_3rd_institutes' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $programData = collect($validated)->except([
            'photos',
            'public_place_1st_institutes',
            'public_place_2nd_institutes',
            'public_place_3rd_institutes',
            'school_place_1st_institutes',
            'school_place_2nd_institutes',
            'school_place_3rd_institutes',
        ])->toArray();

        $programData['public_place_1st_institute'] = implode(', ', $request->input('public_place_1st_institutes', []));
        $programData['public_place_2nd_institute'] = implode(', ', $request->input('public_place_2nd_institutes', []));
        $programData['public_place_3rd_institute'] = implode(', ', $request->input('public_place_3rd_institutes', []));

        $programData['school_place_1st_institute'] = implode(', ', $request->input('school_place_1st_institutes', []));
        $programData['school_place_2nd_institute'] = implode(', ', $request->input('school_place_2nd_institutes', []));
        $programData['school_place_3rd_institute'] = implode(', ', $request->input('school_place_3rd_institutes', []));

        $program = NationalProductivityCompetition::create($programData);

        if ($request->hasFile('photos')) {
            $path = public_path('uploads/npc');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '_' . $photo->getClientOriginalName();
                $photo->move($path, $filename);
                $filePath = 'uploads/npc/' . $filename;

                GalleryImage::create([
                    'program_type' => 'national_productivity',
                    'program_id' => $program->id,
                    'file_path' => $filePath,
                    'caption' => 'NPC Program (Vote: ' . $program->vote_number . ') at ' . $program->place . ' on ' . $program->conducted_date,
                ]);
            }
        }

        return redirect()->route('npc.index')->with('success', 'NPC criteria program added successfully.');
    }

    public function show($id)
    {
        $program = NationalProductivityCompetition::findOrFail($id);
        return view('national_productivity.show', compact('program'));
    }

    public function edit($id)
    {
        $program = NationalProductivityCompetition::findOrFail($id);
        return view('national_productivity.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = NationalProductivityCompetition::findOrFail($id);

        $validated = $request->validate([
            'received_allocation' => 'required|string',
            'vote_number' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'conducted_date' => 'required|date',
            'place' => 'required|string|max:255',
            'participants_public' => 'required|integer|min:0',
            'participants_school' => 'required|integer|min:0',
            'participants_private' => 'required|integer|min:0',
            'public_applications_count' => 'required|integer|min:0',
            'public_selected_count' => 'required|integer|min:0',
            'place_1st_count' => 'required|integer|min:0',
            'place_2nd_count' => 'required|integer|min:0',
            'place_3rd_count' => 'required|integer|min:0',
            'special_commentation_count' => 'required|integer|min:0',
            'commentation_count' => 'required|integer|min:0',
            'school_applications_count' => 'required|integer|min:0',
            'school_selected_count' => 'required|integer|min:0',
            'school_place_1st_count' => 'required|integer|min:0',
            'school_place_2nd_count' => 'required|integer|min:0',
            'school_place_3rd_count' => 'required|integer|min:0',
            'school_special_commentation_count' => 'required|integer|min:0',
            'school_commentation_count' => 'required|integer|min:0',
            'public_place_1st_institutes' => 'nullable|array',
            'public_place_2nd_institutes' => 'nullable|array',
            'public_place_3rd_institutes' => 'nullable|array',
            'school_place_1st_institutes' => 'nullable|array',
            'school_place_2nd_institutes' => 'nullable|array',
            'school_place_3rd_institutes' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $programData = collect($validated)->except([
            'photos',
            'public_place_1st_institutes',
            'public_place_2nd_institutes',
            'public_place_3rd_institutes',
            'school_place_1st_institutes',
            'school_place_2nd_institutes',
            'school_place_3rd_institutes',
        ])->toArray();

        $programData['public_place_1st_institute'] = implode(', ', $request->input('public_place_1st_institutes', []));
        $programData['public_place_2nd_institute'] = implode(', ', $request->input('public_place_2nd_institutes', []));
        $programData['public_place_3rd_institute'] = implode(', ', $request->input('public_place_3rd_institutes', []));

        $programData['school_place_1st_institute'] = implode(', ', $request->input('school_place_1st_institutes', []));
        $programData['school_place_2nd_institute'] = implode(', ', $request->input('school_place_2nd_institutes', []));
        $programData['school_place_3rd_institute'] = implode(', ', $request->input('school_place_3rd_institutes', []));

        $program->update($programData);

        if ($request->hasFile('photos')) {
            $path = public_path('uploads/npc');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '_' . $photo->getClientOriginalName();
                $photo->move($path, $filename);
                $filePath = 'uploads/npc/' . $filename;

                GalleryImage::create([
                    'program_type' => 'national_productivity',
                    'program_id' => $program->id,
                    'file_path' => $filePath,
                    'caption' => 'NPC Program (Vote: ' . $program->vote_number . ') at ' . $program->place . ' on ' . $program->conducted_date,
                ]);
            }
        }

        return redirect()->route('npc.index')->with('success', 'NPC criteria program updated successfully.');
    }

    public function destroy($id)
    {
        $program = NationalProductivityCompetition::findOrFail($id);

        // Delete associated gallery photos
        $photos = GalleryImage::where('program_type', 'national_productivity')
            ->where('program_id', $program->id)
            ->get();

        foreach ($photos as $photo) {
            if (File::exists(public_path($photo->file_path))) {
                File::delete(public_path($photo->file_path));
            }
            $photo->delete();
        }

        $program->delete();

        return redirect()->route('npc.index')->with('success', 'NPC criteria program deleted successfully.');
    }

    public function report($id)
    {
        $program = NationalProductivityCompetition::findOrFail($id);
        return view('national_productivity.report', compact('program'));
    }

    public function downloadReport($id)
    {
        // Increase execution time limit for PDF generation
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $program = NationalProductivityCompetition::findOrFail($id);
        $fileName = 'npc_report_' . $program->id . '.pdf';
        $storagePath = storage_path('app/public/reports/' . $fileName);
        // If PDF already exists, serve it directly
        if (file_exists($storagePath)) {
            return response()->download($storagePath, $fileName);
        }
        // Generate PDF and store it
        $pdf = Pdf::loadView('national_productivity.report_pdf', compact('program'));
        // Ensure directory exists
        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }
        $pdf->save($storagePath);
        return response()->download($storagePath, $fileName);
    }
}
