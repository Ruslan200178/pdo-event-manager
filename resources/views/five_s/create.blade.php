@extends('layouts.app')

@section('title', 'Log 5S Certification')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add 5S Entry</h1>
            <p class="text-xs text-gray-500">Record a new 5S certification audit detail.</p>
        </div>
        <div>
            <a href="{{ route('five-s.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('five-s.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Program Name -->
                    <div>
                        <label for="program_name" class="block text-xs font-semibold text-gray-700 tracking-wide">Program Name / Title</label>
                        <input type="text" name="program_name" id="program_name" required value="{{ old('program_name') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Institution -->
                    <div>
                        <label for="institution" class="block text-xs font-semibold text-gray-700 tracking-wide">Institution / Office Name</label>
                        <input type="text" name="institution" id="institution" required value="{{ old('institution') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-xs font-semibold text-gray-700 tracking-wide">Audit Date</label>
                        <input type="date" name="date" id="date" required value="{{ old('date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Division -->
                    <div>
                        <label for="division" class="block text-xs font-semibold text-gray-700 tracking-wide">DS Division</label>
                        <input type="text" name="division" id="division" required value="{{ old('division') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Participants Count -->
                    <div>
                        <label for="participants_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Participants Count</label>
                        <input type="number" name="participants_count" id="participants_count" required min="0" value="{{ old('participants_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs font-semibold text-gray-700 tracking-wide">Certification Status</label>
                        <select name="status" id="status" required class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Certified" {{ old('status') === 'Certified' ? 'selected' : '' }}>Certified</option>
                            <option value="Rejected" {{ old('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Document Upload -->
                    <div>
                        <label for="document" class="block text-xs font-semibold text-gray-700 tracking-wide">Audit Report / Certificate <span class="text-gray-400 font-normal">(Images/PDFs up to 5MB)</span></label>
                        <input type="file" name="document" id="document" accept="image/*,application/pdf" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('five-s.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Record</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
