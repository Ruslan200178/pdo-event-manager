<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\NationalProductivityCompetition;
use App\Models\CommunityModelVillage;
use Illuminate\Support\Facades\File;
use App\Models\Notification;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $selectedType = $request->query('type');
        $selectedEvent = $request->query('event'); // program_id
        
        // Get distinct program types with count of images
        $categories = GalleryImage::selectRaw('program_type, COUNT(*) as image_count')
            ->groupBy('program_type')
            ->get();

        $images = null;
        $events = null;
        $eventInfo = null;

        if ($selectedType && $selectedEvent) {
            // Level 3: Show images for a specific event
            $images = GalleryImage::where('program_type', $selectedType)
                ->where('program_id', $selectedEvent)
                ->latest()
                ->paginate(12)
                ->appends(['type' => $selectedType, 'event' => $selectedEvent]);

            // Get event details
            $eventInfo = $this->getEventInfo($selectedType, $selectedEvent);

        } elseif ($selectedType) {
            // Level 2: Show event sub-folders grouped by program_id
            $events = GalleryImage::selectRaw('program_id, MIN(caption) as caption, COUNT(*) as image_count, MIN(created_at) as first_upload')
                ->where('program_type', $selectedType)
                ->groupBy('program_id')
                ->orderByDesc('first_upload')
                ->get();

            // Enrich each event with details from the parent model
            foreach ($events as $event) {
                $event->details = $this->getEventInfo($selectedType, $event->program_id);
            }

            // If no events have program_id (general uploads), show images directly
            $allNull = $events->every(fn($e) => is_null($e->program_id));
            if ($allNull) {
                $images = GalleryImage::where('program_type', $selectedType)
                    ->latest()
                    ->paginate(12)
                    ->appends(['type' => $selectedType]);
                $events = null;
            }
        }

        return view('gallery.index', compact('images', 'categories', 'selectedType', 'events', 'selectedEvent', 'eventInfo'));
    }

    /**
     * Fetch event details (place, date, name) from the parent model.
     */
    private function getEventInfo($type, $programId)
    {
        if (!$programId) return null;

        switch ($type) {
            case 'national_productivity':
                $program = NationalProductivityCompetition::find($programId);
                if ($program) {
                    return (object)[
                        'title' => 'NPC at ' . $program->place,
                        'subtitle' => 'Vote: ' . $program->vote_number,
                        'date' => $program->conducted_date,
                        'place' => $program->place,
                    ];
                }
                break;
            case 'model_village':
                $program = CommunityModelVillage::find($programId);
                if ($program) {
                    return (object)[
                        'title' => $program->village,
                        'subtitle' => $program->division_name . ' • ' . $program->gn_division,
                        'date' => $program->date ? (is_string($program->date) ? $program->date : $program->date->format('Y-m-d')) : '',
                        'place' => $program->village,
                    ];
                }
                break;
        }
        return null;
    }


    public function upload(Request $request)
    {
        // Validate inputs for multiple images
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'caption' => 'nullable|string|max:255',
            'program_type' => 'nullable|string|max:50',
        ]);

        $captions = $request->input('caption') ? [$request->caption] : [];
        $programType = $request->input('program_type', 'general') ?: 'general';
        $uploaded = false;

        foreach ($request->file('images') as $index => $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/gallery');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            $file->move($path, $filename);
            $filePath = 'uploads/gallery/' . $filename;
            GalleryImage::create([
                'program_type' => $programType,
                'file_path' => $filePath,
                'caption' => $captions[$index] ?? null,
            ]);
            $uploaded = true;
        }

        if ($uploaded) {
            Notification::create([
                'title' => 'Gallery Images Uploaded',
                'message' => 'Multiple images were uploaded to the gallery.',
                'read' => false,
            ]);
            return redirect()->route('gallery.index')->with('success', 'Images uploaded successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload images.');
    }


    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);

        if (File::exists(public_path($image->file_path))) {
            File::delete(public_path($image->file_path));
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gallery image deleted.');
    }
}
