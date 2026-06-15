<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingProgram;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\File;
use App\Models\Notification;

class TrainingProgramController extends Controller
{
    public function index()
    {
        $programs = TrainingProgram::latest()->paginate(10);
        return view('training.index', compact('programs'));
    }

    public function create()
    {
        return view('training.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'institution' => 'required|string|max:255',
            'district' => 'required|string|max:100',
            'participants_count' => 'required|integer|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Up to 5MB per image
        ]);

        $program = TrainingProgram::create([
            'date' => $validated['date'],
            'institution' => $validated['institution'],
            'district' => $validated['district'],
            'participants_count' => $validated['participants_count'],
        ]);

        if ($request->hasFile('photos')) {
            $path = public_path('uploads/training');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '_' . $photo->getClientOriginalName();
                $photo->move($path, $filename);
                $filePath = 'uploads/training/' . $filename;

                GalleryImage::create([
                    'program_type' => 'training',
                    'program_id' => $program->id,
                    'file_path' => $filePath,
                    'caption' => 'Training Program at ' . $program->institution,
                ]);
            }
        }

        Notification::create([
            'title' => 'Training Program Recorded',
            'message' => "New training program for '{$request->institution}' logged successfully.",
            'read' => false
        ]);

        return redirect()->route('training.index')->with('success', 'Training program logged successfully.');
    }

    public function show($id)
    {
        $program = TrainingProgram::findOrFail($id);
        $photos = GalleryImage::where('program_type', 'training')
            ->where('program_id', $program->id)
            ->get();
        return view('training.show', compact('program', 'photos'));
    }

    public function edit($id)
    {
        $program = TrainingProgram::findOrFail($id);
        $photos = GalleryImage::where('program_type', 'training')
            ->where('program_id', $program->id)
            ->get();
        return view('training.edit', compact('program', 'photos'));
    }

    public function update(Request $request, $id)
    {
        $program = TrainingProgram::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'institution' => 'required|string|max:255',
            'district' => 'required|string|max:100',
            'participants_count' => 'required|integer|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $program->update([
            'date' => $validated['date'],
            'institution' => $validated['institution'],
            'district' => $validated['district'],
            'participants_count' => $validated['participants_count'],
        ]);

        if ($request->hasFile('photos')) {
            $path = public_path('uploads/training');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '_' . $photo->getClientOriginalName();
                $photo->move($path, $filename);
                $filePath = 'uploads/training/' . $filename;

                GalleryImage::create([
                    'program_type' => 'training',
                    'program_id' => $program->id,
                    'file_path' => $filePath,
                    'caption' => 'Training Program at ' . $program->institution,
                ]);
            }
        }

        Notification::create([
            'title' => 'Training Program Updated',
            'message' => "Training program at '{$request->institution}' has been updated.",
            'read' => false
        ]);

        return redirect()->route('training.index')->with('success', 'Training program updated successfully.');
    }

    public function destroy($id)
    {
        $program = TrainingProgram::findOrFail($id);

        // Delete associated gallery files and records
        $photos = GalleryImage::where('program_type', 'training')
            ->where('program_id', $program->id)
            ->get();

        foreach ($photos as $photo) {
            if (File::exists(public_path($photo->file_path))) {
                File::delete(public_path($photo->file_path));
            }
            $photo->delete();
        }

        $program->delete();

        return redirect()->route('training.index')->with('success', 'Training program and associated photos deleted.');
    }
}
