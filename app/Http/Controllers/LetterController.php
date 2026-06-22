<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $lettersQuery = Letter::orderByDesc('date');

        if ($search) {
            $lettersQuery->where(function($q) use ($search) {
                $q->where('reference_number', 'like', '%' . $search . '%')
                  ->orWhere('institution', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }

        $letters = $lettersQuery->paginate(10)->appends(['search' => $search]);

        return view('letters.index', compact('letters', 'search'));
    }

    public function create()
    {
        return view('letters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'reference_number' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        Letter::create($validated);

        return redirect()->route('letters.index')->with('success', 'Letter record created successfully.');
    }

    public function edit(Letter $letter)
    {
        return view('letters.edit', compact('letter'));
    }

    public function update(Request $request, Letter $letter)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'reference_number' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $letter->update($validated);

        return redirect()->route('letters.index')->with('success', 'Letter record updated successfully.');
    }

    public function show(Letter $letter)
    {
        return view('letters.show', compact('letter'));
    }

    public function destroy(Letter $letter)
    {
        $letter->delete();

        return redirect()->route('letters.index')->with('success', 'Letter record deleted successfully.');
    }

    public function report(Letter $letter)
    {
        return view('letters.report', compact('letter'));
    }

    public function downloadReport(Letter $letter)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $fileName = 'letter_report_' . $letter->id . '.pdf';
        $storagePath = storage_path('app/public/reports/' . $fileName);
        
        if (file_exists($storagePath)) {
            return response()->download($storagePath, $fileName);
        }
        
        $pdf = Pdf::loadView('letters.report_pdf', compact('letter'));
        
        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }
        
        $pdf->save($storagePath);
        return response()->download($storagePath, $fileName);
    }
}
