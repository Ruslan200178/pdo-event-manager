@extends('layouts.app')

@section('title', 'Modify Archived Document')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Archive Entry</h1>
            <p class="text-xs text-gray-500">Update archived document specifications or replace the uploaded file attachment.</p>
        </div>
        <div>
            <a href="{{ route('archive.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-55 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('archive.update', $archive->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-xs font-semibold text-gray-700 tracking-wide">Calendar Year</label>
                        <input type="number" name="year" id="year" required min="2000" max="2100" value="{{ old('year', $archive->year) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- DS Division -->
                    <div>
                        <label for="division" class="block text-xs font-semibold text-gray-700 tracking-wide">DS Division</label>
                        <input type="text" name="division" id="division" required value="{{ old('division', $archive->division) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Module Name -->
                    <div>
                        <label for="module_name" class="block text-xs font-semibold text-gray-700 tracking-wide">Program Module</label>
                        <select name="module_name" id="module_name" required class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            <option value="">Select Module</option>
                            @foreach($modules as $m)
                                <option value="{{ $m }}" {{ old('module_name', $archive->module_name) == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-semibold text-gray-755 tracking-wide">Document / Project Title</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $archive->title) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-xs font-semibold text-gray-700 tracking-wide">Replace Attachment File <span class="text-gray-400 font-normal">(PDF, Word, Excel up to 10MB)</span></label>
                        <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,image/*" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                        @if($archive->file_path)
                            <p class="text-[10px] text-govblue-600 font-semibold mt-1"><i class="fa-solid fa-paperclip"></i> Current file: {{ basename($archive->file_path) }}</p>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-gray-755 tracking-wide">Description / Archive Abstract</label>
                    <textarea name="description" id="description" rows="5" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">{{ old('description', $archive->description) }}</textarea>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('archive.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
