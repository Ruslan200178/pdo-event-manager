<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use Illuminate\Support\Facades\File;
use App\Models\Notification;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->query('year');
        $search = $request->query('search');
        $module = $request->query('module_name');

        $query = Archive::latest();

        if ($year) {
            $query->where('year', $year);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('division', 'like', '%' . $search . '%')
                  ->orWhere('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        if ($module) {
            $query->where('module_name', $module);
        }

        $archives = $query->paginate(10)->appends(['year' => $year, 'search' => $search, 'module_name' => $module]);

        // Fetch unique years and modules for filter options
        $years = Archive::distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
        $modules = ['NPC', 'CMV', 'Citizen Mirror', 'ProYouth', '4i Project', 'Letter Management', '5S', 'Certification Course', 'Training', 'Officers'];

        return view('archive.index', compact('archives', 'years', 'modules', 'year', 'search', 'module'));
    }

    public function create()
    {
        $modules = ['NPC', 'CMV', 'Citizen Mirror', 'ProYouth', '4i Project', 'Letter Management', '5S', 'Certification Course', 'Training', 'Officers'];
        return view('archive.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'division' => 'required|string|max:100',
            'module_name' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpeg,png,jpg|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/archive');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['file_path'] = 'uploads/archive/' . $filename;
        }

        unset($validated['file']);
        Archive::create($validated);

        Notification::create([
            'title' => 'Document Archived',
            'message' => "Document '{$request->title}' was successfully added to archives.",
            'read' => false
        ]);

        return redirect()->route('archive.index')->with('success', 'Document archived successfully.');
    }

    public function show($id)
    {
        $archive = Archive::findOrFail($id);
        return view('archive.show', compact('archive'));
    }

    public function edit($id)
    {
        $archive = Archive::findOrFail($id);
        $modules = ['NPC', 'CMV', 'Citizen Mirror', 'ProYouth', '4i Project', 'Letter Management', '5S', 'Certification Course', 'Training', 'Officers'];
        return view('archive.edit', compact('archive', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $archive = Archive::findOrFail($id);

        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'division' => 'required|string|max:100',
            'module_name' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($archive->file_path && File::exists(public_path($archive->file_path))) {
                File::delete(public_path($archive->file_path));
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/archive');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['file_path'] = 'uploads/archive/' . $filename;
        }

        unset($validated['file']);
        $archive->update($validated);

        Notification::create([
            'title' => 'Archive Updated',
            'message' => "Archived document '{$request->title}' details were updated.",
            'read' => false
        ]);

        return redirect()->route('archive.index')->with('success', 'Archive document updated successfully.');
    }

    public function destroy($id)
    {
        $archive = Archive::findOrFail($id);

        if ($archive->file_path && File::exists(public_path($archive->file_path))) {
            File::delete(public_path($archive->file_path));
        }

        $archive->delete();

        return redirect()->route('archive.index')->with('success', 'Archive entry deleted successfully.');
    }

    public function download($id)
    {
        $archive = Archive::findOrFail($id);
        $filePath = public_path($archive->file_path);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'The requested file does not exist on the server.');
    }
}
