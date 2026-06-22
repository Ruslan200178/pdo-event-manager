<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiveSCertification;
use Illuminate\Support\Facades\File;
use App\Models\Notification;

class FiveSController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = FiveSCertification::latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('program_name', 'like', '%' . $search . '%')
                  ->orWhere('institution', 'like', '%' . $search . '%');
            });
        }

        $records = $query->paginate(10)->appends(['search' => $search]);
        return view('five_s.index', compact('records', 'search'));
    }

    public function create()
    {
        return view('five_s.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'date' => 'required|date',
            'division' => 'required|string|max:100',
            'participants_count' => 'required|integer|min:0',
            'status' => 'required|string|in:Pending,Certified,Rejected',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/five_s');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['document_path'] = 'uploads/five_s/' . $filename;
        }

        unset($validated['document']);
        FiveSCertification::create($validated);

        Notification::create([
            'title' => '5S Certification Logged',
            'message' => "A new 5S program '{$request->program_name}' has been added for '{$request->institution}'.",
            'read' => false
        ]);

        return redirect()->route('five-s.index')->with('success', '5S program logged successfully.');
    }

    public function show($id)
    {
        $record = FiveSCertification::findOrFail($id);
        return view('five_s.show', compact('record'));
    }

    public function edit($id)
    {
        $record = FiveSCertification::findOrFail($id);
        return view('five_s.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = FiveSCertification::findOrFail($id);

        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'date' => 'required|date',
            'division' => 'required|string|max:100',
            'participants_count' => 'required|integer|min:0',
            'status' => 'required|string|in:Pending,Certified,Rejected',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        if ($request->hasFile('document')) {
            // Delete old file
            if ($record->document_path && File::exists(public_path($record->document_path))) {
                File::delete(public_path($record->document_path));
            }

            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/five_s');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['document_path'] = 'uploads/five_s/' . $filename;
        }

        unset($validated['document']);
        $record->update($validated);

        Notification::create([
            'title' => '5S Certification Updated',
            'message' => "5S program '{$request->program_name}' status has been set to '{$request->status}'.",
            'read' => false
        ]);

        return redirect()->route('five-s.index')->with('success', '5S certification updated successfully.');
    }

    public function destroy($id)
    {
        $record = FiveSCertification::findOrFail($id);

        if ($record->document_path && File::exists(public_path($record->document_path))) {
            File::delete(public_path($record->document_path));
        }

        $record->delete();

        return redirect()->route('five-s.index')->with('success', '5S certification entry deleted.');
    }
}
