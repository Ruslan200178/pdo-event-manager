<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FourIController extends Controller
{
    /**
     * Display the 4i program index page with Allocation details.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $allocationsQuery = \App\Models\Allocation::with('images')->orderByDesc('date');

        if ($search) {
            $allocationsQuery->where(function($q) use ($search) {
                $q->where('purpose', 'like', '%' . $search . '%')
                  ->orWhere('division_name', 'like', '%' . $search . '%')
                  ->orWhere('program_type', 'like', '%' . $search . '%');
            });
        }

        $allocations = $allocationsQuery->paginate(10)->appends(['search' => $search]);

        return view('fouri.index', compact('allocations', 'search'));
    }
}
