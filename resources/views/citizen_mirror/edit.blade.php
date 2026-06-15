@extends('layouts.app')

@section('title', 'Edit Citizen Mirror')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Citizen Mirror Entry</h1>
            <p class="text-xs text-gray-500">Modify the recorded survey findings, feedback comments, and outcomes.</p>
        </div>
        <div>
            <a href="{{ route('citizen-mirror.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('citizen-mirror.update', $entry->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-semibold text-gray-700 tracking-wide">Record Title / Agenda</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $entry->title) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- DS Division -->
                    <div>
                        <label for="division" class="block text-xs font-semibold text-gray-700 tracking-wide">DS Division</label>
                        <input type="text" name="division" id="division" required value="{{ old('division', $entry->division) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-xs font-semibold text-gray-700 tracking-wide">Conducted Date</label>
                        <input type="date" name="date" id="date" required value="{{ old('date', $entry->date) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="document" class="block text-xs font-semibold text-gray-700 tracking-wide">Replace Attachment <span class="text-gray-400 font-normal">(Images/PDFs)</span></label>
                        <input type="file" name="document" id="document" accept="image/*,application/pdf" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                        @if($entry->document_path)
                            <p class="text-[10px] text-govblue-600 font-semibold mt-1"><i class="fa-solid fa-paperclip"></i> Current: {{ basename($entry->document_path) }}</p>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-gray-700 tracking-wide">Detailed Description / Summary</label>
                    <textarea name="description" id="description" rows="5" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">{{ old('description', $entry->description) }}</textarea>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('citizen-mirror.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
