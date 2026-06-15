@extends('layouts.app')

@section('title', 'Certification Course Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Certification Course Details</h1>
            <p class="text-xs text-gray-500">Full information for the selected productivity training course.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('courses.edit', $course->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Course</span>
            </a>
        </div>
    </div>

    <!-- details Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $course->institution }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Academic Year: <span class="font-bold text-govblue-700">{{ $course->year }}</span></p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Certification Course
                    </span>
                </div>
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Students count -->
                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-govblue-50 text-govblue-900 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-450 uppercase block">Enrolled Students</span>
                        <span class="text-lg font-bold text-gray-800">{{ $course->students_count }}</span>
                    </div>
                </div>

                <!-- Modules count -->
                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-govblue-50 text-govblue-900 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-450 uppercase block">Course Modules</span>
                        <span class="text-lg font-bold text-gray-800">{{ $course->modules_count }}</span>
                    </div>
                </div>

                <!-- Eligible Students -->
                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-900 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-square-check"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-450 uppercase block">Passed / Eligible</span>
                        <span class="text-lg font-bold text-emerald-800">{{ $course->eligible_students_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Dates section -->
            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-3">Key Milestones & Timeline</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="flex items-center justify-between p-3 bg-gray-55 border border-gray-100 rounded-xl">
                        <span class="text-gray-500 font-medium">Starting Date</span>
                        <span class="font-bold text-gray-850">{{ $course->starting_date }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-55 border border-gray-100 rounded-xl">
                        <span class="text-gray-500 font-medium">Closing Date</span>
                        <span class="font-bold text-gray-850">{{ $course->closing_date }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-55 border border-gray-100 rounded-xl">
                        <span class="text-gray-500 font-medium">Exam Conducted Date</span>
                        <span class="font-bold text-gray-850">{{ $course->exam_date ?: 'TBD' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-55 border border-gray-100 rounded-xl">
                        <span class="text-gray-500 font-medium">Ceremony Date</span>
                        <span class="font-bold text-gray-850">{{ $course->ceremony_date ?: 'TBD' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
