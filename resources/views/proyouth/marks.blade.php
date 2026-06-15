@extends('layouts.app')

@section('title', 'Evaluate Participant')

@section('content')
<div class="max-w-xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Evaluate Participant</h1>
            <p class="text-xs text-gray-500">Assign marks to the youth program participant.</p>
        </div>
        <div>
            <a href="{{ route('proyouth.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="bg-govblue-900 text-white p-6">
            <span class="text-[10px] font-bold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded">
                {{ $type === 'video' ? 'AI Video Competition' : 'Project Proposal Competition' }}
            </span>
            <h3 class="text-lg font-bold mt-2">{{ $participant->name }}</h3>
            <p class="text-xs text-blue-200 mt-1">NIC: {{ $participant->nic_number }} | Institution: {{ $participant->institute_school }}</p>
        </div>
        
        <form action="{{ route('proyouth.marks.update', ['type' => $type, 'id' => $id]) }}" method="POST">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <!-- Marks Input -->
                <div>
                    <label for="marks" class="block text-xs font-semibold text-gray-700 tracking-wide">Assign Marks (0 to 100)</label>
                    <div class="mt-1.5 relative rounded-xl shadow-sm max-w-[12rem]">
                        <input type="number" name="marks" id="marks" min="0" max="100" required value="{{ old('marks', $marks) }}" class="block w-full pr-12 px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 font-bold text-gray-850">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-xs font-bold">/ 100</span>
                        </div>
                    </div>
                    @error('marks')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('proyouth.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-square-check"></i>
                    <span>Submit Evaluation</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
