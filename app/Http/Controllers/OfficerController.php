<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Officer;
use Illuminate\Support\Facades\File;
use App\Models\Notification;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = Officer::latest()->paginate(12);
        return view('officers.index', compact('officers'));
    }

    public function create()
    {
        return view('officers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_name' => 'required|string|max:100',
            'nic_number' => 'required|string|max:20',
            'appointment_date' => 'required|date',
            'service_details' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'district_rank' => 'nullable|string|max:100',
            'divisional_secretariat' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/officers');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['photo_path'] = 'uploads/officers/' . $filename;
        }

        unset($validated['photo']);
        Officer::create($validated);

        Notification::create([
            'title' => 'Officer Registered',
            'message' => "Officer '{$request->name}' registered successfully.",
            'read' => false
        ]);

        return redirect()->route('officers.index')->with('success', 'Officer profile created.');
    }

    public function show($id)
    {
        $officer = Officer::findOrFail($id);
        return view('officers.show', compact('officer'));
    }

    public function edit($id)
    {
        $officer = Officer::findOrFail($id);
        return view('officers.edit', compact('officer'));
    }

    public function update(Request $request, $id)
    {
        $officer = Officer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_name' => 'required|string|max:100',
            'nic_number' => 'required|string|max:20',
            'appointment_date' => 'required|date',
            'service_details' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'district_rank' => 'nullable|string|max:100',
            'divisional_secretariat' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($officer->photo_path && File::exists(public_path($officer->photo_path))) {
                File::delete(public_path($officer->photo_path));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/officers');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $file->move($path, $filename);
            $validated['photo_path'] = 'uploads/officers/' . $filename;
        }

        unset($validated['photo']);
        $officer->update($validated);

        Notification::create([
            'title' => 'Officer Profile Updated',
            'message' => "Officer profile for '{$request->name}' has been updated.",
            'read' => false
        ]);

        return redirect()->route('officers.index')->with('success', 'Officer profile updated.');
    }

    public function destroy($id)
    {
        $officer = Officer::findOrFail($id);

        if ($officer->photo_path && File::exists(public_path($officer->photo_path))) {
            File::delete(public_path($officer->photo_path));
        }

        $officer->delete();

        return redirect()->route('officers.index')->with('success', 'Officer profile deleted.');
    }
}
