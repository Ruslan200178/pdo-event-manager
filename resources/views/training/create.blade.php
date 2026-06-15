@extends('layouts.app')

@section('title', 'Log Training Program')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add Training Program</h1>
            <p class="text-xs text-gray-500">Record details of a conducted productivity training program and attach gallery photos.</p>
        </div>
        <div>
            <a href="{{ route('training.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('training.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-xs font-semibold text-gray-700 tracking-wide">Conducted Date</label>
                        <input type="date" name="date" id="date" required value="{{ old('date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Institution -->
                    <div>
                        <label for="institution" class="block text-xs font-semibold text-gray-700 tracking-wide">Institution / Organization Name</label>
                        <input type="text" name="institution" id="institution" required value="{{ old('institution') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- District -->
                    <div>
                        <label for="district" class="block text-xs font-semibold text-gray-700 tracking-wide">District</label>
                        <input type="text" name="district" id="district" required value="{{ old('district') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Participants Count -->
                    <div>
                        <label for="participants_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Total Participants</label>
                        <input type="number" name="participants_count" id="participants_count" required min="0" value="{{ old('participants_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <!-- Multiple Photo Upload -->
                <div>
                    <label for="photos" class="block text-xs font-semibold text-gray-700 tracking-wide">Gallery Photos <span class="text-gray-400 font-normal">(Select multiple images up to 5MB each)</span></label>
                    <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('training.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Program</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
