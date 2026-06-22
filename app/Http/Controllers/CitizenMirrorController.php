<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CitizenMirror;
use Illuminate\Support\Facades\File;

class CitizenMirrorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = CitizenMirror::latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('division', 'like', '%' . $search . '%');
            });
        }

        $entries = $query->paginate(10)->appends(['search' => $search]);
        return view('citizen_mirror.index', compact('entries', 'search'));
    }

    public function create()
    {
        return view('citizen_mirror.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'division' => 'required|string|max:100',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120', // Up to 5MB
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/citizen_mirror');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            
            $file->move($path, $filename);
            $validated['document_path'] = 'uploads/citizen_mirror/' . $filename;
        }

        unset($validated['document']);
        CitizenMirror::create($validated);

        return redirect()->route('citizen-mirror.index')->with('success', 'Citizen mirror entry recorded.');
    }

    public function show($id)
    {
        $entry = CitizenMirror::findOrFail($id);
        return view('citizen_mirror.show', compact('entry'));
    }

    public function edit($id)
    {
        $entry = CitizenMirror::findOrFail($id);
        return view('citizen_mirror.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $entry = CitizenMirror::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'division' => 'required|string|max:100',
            'document' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
        ]);

        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($entry->document_path && File::exists(public_path($entry->document_path))) {
                File::delete(public_path($entry->document_path));
            }

            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/citizen_mirror');
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            
            $file->move($path, $filename);
            $validated['document_path'] = 'uploads/citizen_mirror/' . $filename;
        }

        unset($validated['document']);
        $entry->update($validated);

        return redirect()->route('citizen-mirror.index')->with('success', 'Citizen mirror entry updated.');
    }

    public function destroy($id)
    {
        $entry = CitizenMirror::findOrFail($id);
        
        if ($entry->document_path && File::exists(public_path($entry->document_path))) {
            File::delete(public_path($entry->document_path));
        }

        $entry->delete();

        return redirect()->route('citizen-mirror.index')->with('success', 'Citizen mirror entry deleted.');
    }
}
