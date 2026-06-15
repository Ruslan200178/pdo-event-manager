<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificationCourse;
use App\Models\Notification;

class CertificationCourseController extends Controller
{
    public function index()
    {
        $courses = CertificationCourse::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'institution' => 'required|string|max:255',
            'students_count' => 'required|integer|min:0',
            'modules_count' => 'required|integer|min:0',
            'starting_date' => 'required|date',
            'closing_date' => 'required|date|after_or_equal:starting_date',
            'exam_date' => 'nullable|date',
            'eligible_students_count' => 'required|integer|min:0',
            'ceremony_date' => 'nullable|date',
        ]);

        CertificationCourse::create($validated);

        Notification::create([
            'title' => 'Course Created',
            'message' => "A new certification course has been added for '{$request->institution}' ({$request->year}).",
            'read' => false
        ]);

        return redirect()->route('courses.index')->with('success', 'Certification course logged successfully.');
    }

    public function show($id)
    {
        $course = CertificationCourse::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = CertificationCourse::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = CertificationCourse::findOrFail($id);

        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'institution' => 'required|string|max:255',
            'students_count' => 'required|integer|min:0',
            'modules_count' => 'required|integer|min:0',
            'starting_date' => 'required|date',
            'closing_date' => 'required|date|after_or_equal:starting_date',
            'exam_date' => 'nullable|date',
            'eligible_students_count' => 'required|integer|min:0',
            'ceremony_date' => 'nullable|date',
        ]);

        $course->update($validated);

        Notification::create([
            'title' => 'Course Updated',
            'message' => "Certification course details updated for '{$request->institution}' ({$request->year}).",
            'read' => false
        ]);

        return redirect()->route('courses.index')->with('success', 'Certification course updated successfully.');
    }

    public function destroy($id)
    {
        $course = CertificationCourse::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Certification course deleted.');
    }
}
