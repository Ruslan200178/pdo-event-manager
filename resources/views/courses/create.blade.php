@extends('layouts.app')

@section('title', 'Create Certification Course')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add Course Entry</h1>
            <p class="text-xs text-gray-500">Record a new certification course details.</p>
        </div>
        <div>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-xs font-semibold text-gray-700 tracking-wide">Academic / Calendar Year</label>
                        <input type="number" name="year" id="year" required min="2000" max="2100" value="{{ old('year', date('Y')) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Institution -->
                    <div>
                        <label for="institution" class="block text-xs font-semibold text-gray-700 tracking-wide">Institution Name</label>
                        <input type="text" name="institution" id="institution" required value="{{ old('institution') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Students Count -->
                    <div>
                        <label for="students_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Enrolled Students Count</label>
                        <input type="number" name="students_count" id="students_count" required min="0" value="{{ old('students_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Modules Count -->
                    <div>
                        <label for="modules_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Total Syllabus Modules</label>
                        <input type="number" name="modules_count" id="modules_count" required min="0" value="{{ old('modules_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Eligible Students Count -->
                    <div>
                        <label for="eligible_students_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Eligible Students (Passed)</label>
                        <input type="number" name="eligible_students_count" id="eligible_students_count" required min="0" value="{{ old('eligible_students_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Starting Date -->
                    <div>
                        <label for="starting_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Starting Date</label>
                        <input type="date" name="starting_date" id="starting_date" required value="{{ old('starting_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Closing Date -->
                    <div>
                        <label for="closing_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Closing Date</label>
                        <input type="date" name="closing_date" id="closing_date" required value="{{ old('closing_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Exam Date -->
                    <div>
                        <label for="exam_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Exam Date <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Ceremony Date -->
                    <div>
                        <label for="ceremony_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Ceremony Date <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="date" name="ceremony_date" id="ceremony_date" value="{{ old('ceremony_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('courses.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Course</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
