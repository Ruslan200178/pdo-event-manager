@extends('layouts.app')

@section('title', 'Edit Letter Entry')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Letter Entry</h1>
            <p class="text-xs text-gray-500 mt-1">Update letter.</p>
        </div>
        <a href="{{ route('letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('letters.update', $letter->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div class="space-y-1.5">
                    <label for="date" class="block text-xs font-semibold text-gray-700">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', $letter->date) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reference Number -->
                <div class="space-y-1.5">
                    <label for="reference_number" class="block text-xs font-semibold text-gray-700">Reference Number <span class="text-red-500">*</span></label>
                    <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $letter->reference_number) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="e.g. PDO/4I/2026/01">
                    @error('reference_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Institution -->
                <div class="space-y-1.5">
                    <label for="institution" class="block text-xs font-semibold text-gray-700">Institution <span class="text-red-500">*</span></label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution', $letter->institution) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="Enter institution name">
                    @error('institution')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="space-y-1.5">
                    <label for="subject" class="block text-xs font-semibold text-gray-700">Subject <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', $letter->subject) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="Enter letter subject">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="space-y-1.5">
                    <label for="deadline" class="block text-xs font-semibold text-gray-700">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $letter->deadline) }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-sm font-semibold shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Update Letter</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
