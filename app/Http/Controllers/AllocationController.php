<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AllocationController extends Controller
{
    public function index()
    {
        return redirect()->route('fouri.index');
    }

    public function create()
    {
        return view('fouri.allocations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string',
            'division_name' => 'required|string|max:255',
            'program_type' => 'required|string|max:255',
            'participants_count' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $allocation = Allocation::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('uploads/allocations', 'public');
                \App\Models\AllocationImage::create([
                    'allocation_id' => $allocation->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('fouri.index')->with('success', 'Allocation record created successfully.');
    }

    public function edit(Allocation $allocation)
    {
        return view('fouri.allocations.edit', compact('allocation'));
    }

    public function update(Request $request, Allocation $allocation)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string',
            'division_name' => 'required|string|max:255',
            'program_type' => 'required|string|max:255',
            'participants_count' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $allocation->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('uploads/allocations', 'public');
                \App\Models\AllocationImage::create([
                    'allocation_id' => $allocation->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('fouri.index')->with('success', 'Allocation record updated successfully.');
    }

    public function destroy(Allocation $allocation)
    {
        $allocation->delete();

        return redirect()->route('fouri.index')->with('success', 'Allocation record deleted successfully.');
    }

    public function show(Allocation $allocation)
    {
        // Load allocation with images
        $allocation->load('images');
        return view('fouri.allocations.show', compact('allocation'));
    }

    public function destroyImage(\App\Models\AllocationImage $image)
    {
        // Delete physical file
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function report(Allocation $allocation)
    {
        $allocation->load('images');
        return view('fouri.allocations.report', compact('allocation'));
    }

    public function downloadReport(Allocation $allocation)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $allocation->load('images');
        $fileName = 'allocation_report_' . $allocation->id . '.pdf';
        $storagePath = storage_path('app/public/reports/' . $fileName);
        
        if (file_exists($storagePath)) {
            return response()->download($storagePath, $fileName);
        }
        
        $pdf = Pdf::loadView('fouri.allocations.report_pdf', compact('allocation'));
        
        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }
        
        $pdf->save($storagePath);
        return response()->download($storagePath, $fileName);
    }
}
