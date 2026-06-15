<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityModelVillage;
use App\Models\GalleryImage;
use App\Models\Notification;
use Illuminate\Support\Facades\File;

class CommunityModelVillageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = CommunityModelVillage::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('village', 'like', "%{$search}%")
                  ->orWhere('vote_number', 'like', "%{$search}%");
            });
        }
        $villages = $query->latest()->paginate(10)->appends(['search' => $search]);
        $villagesAll = CommunityModelVillage::orderBy('division_name')
            ->orderBy('gn_division')
            ->orderBy('village')
            ->get();
        $divisions = CommunityModelVillage::selectRaw('division_name, SUM(district_allocation) as total_allocation, SUM(amount) as total_spent, COUNT(id) as village_count')
            ->groupBy('division_name')
            ->get();

        return view('community_model_village.index', compact('villages', 'divisions', 'villagesAll', 'search'));
    }

    public function create()
    {
        $dsDivisions = CommunityModelVillage::distinct('division_name')->pluck('division_name');
        return view('community_model_village.create', compact('dsDivisions'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'district_allocation' => 'required|numeric|min:0',
            'vote_number' => 'required|string|max:50',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string',
            'division_name' => 'required|string|max:100',
            'gn_division' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'contacted_staff' => 'required|string|max:255',
            'awareness_date' => 'nullable|date',
            'stakeholder_awareness_date' => 'nullable|date',
            'participants_count' => 'required|integer|min:0',
            'launching_date' => 'nullable|date',
            'ceremony_participants_count' => 'required|integer|min:0',
            // optional multiple images
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Create the model village entry first
        $village = CommunityModelVillage::create($validated);

        $uploaded = false;
        if ($request->hasFile('images')) {
            $path = public_path('uploads/model_village');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move($path, $filename);
                $filePath = 'uploads/model_village/' . $filename;
                GalleryImage::create([
                    'program_type' => 'model_village',
                    'program_id' => $village->id,
                    'file_path' => $filePath,
                    'caption' => null,
                ]);
                $uploaded = true;
            }
        }

        if ($uploaded) {
            Notification::create([
                'title' => 'Model Village Images Uploaded',
                'message' => 'Images were added for village: ' . $village->village,
                'read' => false,
            ]);
        }

        return redirect()->route('cmv.index')
            ->with('success', 'Model village program entry created.');
    }


    public function show($id)
    {
        $village = CommunityModelVillage::findOrFail($id);
        return view('community_model_village.show', compact('village'));
    }

    public function edit($id)
    {
        $village = CommunityModelVillage::findOrFail($id);
        $dsDivisions = CommunityModelVillage::distinct('division_name')->pluck('division_name');
        return view('community_model_village.edit', compact('village', 'dsDivisions'));
    }

    public function update(Request $request, $id)
    {
        $village = CommunityModelVillage::findOrFail($id);

        $validated = $request->validate([
            'district_allocation' => 'required|numeric|min:0',
            'vote_number' => 'required|string|max:50',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string',
            'division_name' => 'required|string|max:100',
            'gn_division' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'contacted_staff' => 'required|string|max:255',
            'awareness_date' => 'nullable|date',
            'stakeholder_awareness_date' => 'nullable|date',
            'participants_count' => 'required|integer|min:0',
            'launching_date' => 'nullable|date',
            'ceremony_participants_count' => 'required|integer|min:0',
        ]);

        $village->update($validated);

        return redirect()->route('cmv.index')->with('success', 'Model village program entry updated.');
    }

    public function destroy($id)
    {
        $village = CommunityModelVillage::findOrFail($id);
        $village->delete();

        return redirect()->route('cmv.index')->with('success', 'Model village program entry deleted.');
    }
}
