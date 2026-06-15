@extends('layouts.app')

@section('title', 'Certification Courses')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Certification Courses</h1>
            <p class="text-xs text-gray-500">Manage government-sponsored productivity certification training courses, students, and certificates.</p>
        </div>
        <div>
            <a href="{{ route('courses.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Course Entry</span>
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Year</th>
                            <th class="pb-3">Institution</th>
                            <th class="pb-3">Students</th>
                            <th class="pb-3">Modules</th>
                            <th class="pb-3">Start Date</th>
                            <th class="pb-3">End Date</th>
                            <th class="pb-3">Exam Date</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-bold text-gray-800">{{ $course->year }}</td>
                                <td class="py-3.5 text-gray-700 font-semibold">{{ $course->institution }}</td>
                                <td class="py-3.5">{{ $course->students_count }} Students</td>
                                <td class="py-3.5">{{ $course->modules_count }} Modules</td>
                                <td class="py-3.5">{{ $course->starting_date }}</td>
                                <td class="py-3.5">{{ $course->closing_date }}</td>
                                <td class="py-3.5">{{ $course->exam_date ?: '-' }}</td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('courses.show', $course->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('courses.edit', $course->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course log?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-graduation-cap text-2xl mb-2 block text-gray-300"></i>
                                    No courses logged yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
