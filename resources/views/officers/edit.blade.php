@extends('layouts.app')

@section('title', 'Modify Officer Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Officer Profile</h1>
            <p class="text-xs text-gray-500">Update officer record info and profile photo upload.</p>
        </div>
        <div>
            <a href="{{ route('officers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-55 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Grid</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('officers.update', $officer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 tracking-wide">Full Name</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $officer->name) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Division Name -->
                    <div>
                        <label for="division_name" class="block text-xs font-semibold text-gray-700 tracking-wide">Assigned DS Division</label>
                        <input type="text" name="division_name" id="division_name" required value="{{ old('division_name', $officer->division_name) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIC Number -->
                    <div>
                        <label for="nic_number" class="block text-xs font-semibold text-gray-700 tracking-wide">NIC Number</label>
                        <input type="text" name="nic_number" id="nic_number" required value="{{ old('nic_number', $officer->nic_number) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Appointment Date -->
                    <div>
                        <label for="appointment_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" required value="{{ old('appointment_date', $officer->appointment_date) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Divisional Secretariat -->
                    <div>
                        <label for="divisional_secretariat" class="block text-xs font-semibold text-gray-700 tracking-wide">Divisional Secretariat</label>
                        <input type="text" name="divisional_secretariat" id="divisional_secretariat" value="{{ old('divisional_secretariat', $officer->divisional_secretariat) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500" placeholder="e.g. Trincomalee">
                    </div>

                    <!-- District Rank -->
                    <div>
                        <label for="district_rank" class="block text-xs font-semibold text-gray-700 tracking-wide">District Rank</label>
                        <input type="text" name="district_rank" id="district_rank" value="{{ old('district_rank', $officer->district_rank) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500" placeholder="e.g. 1st, 2nd, etc.">
                    </div>

                    <!-- Progress Percentage -->
                    <div>
                        <label for="progress_percentage" class="block text-xs font-semibold text-gray-700 tracking-wide">Progress Percentage (%)</label>
                        <input type="number" name="progress_percentage" id="progress_percentage" min="0" max="100" value="{{ old('progress_percentage', $officer->progress_percentage) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500" placeholder="e.g. 75">
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="flex flex-col sm:flex-row gap-6 sm:items-center">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-govblue-500 flex-shrink-0 flex items-center justify-center bg-gray-50">
                        @if($officer->photo_path)
                            <img src="{{ asset($officer->photo_path) }}" alt="{{ $officer->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user-tie text-gray-400 text-2xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="photo" class="block text-xs font-semibold text-gray-700 tracking-wide">Replace Profile Photo <span class="text-gray-400 font-normal">(Square aspect ratio images, max 2MB)</span></label>
                        <input type="file" name="photo" id="photo" accept="image/*" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                    </div>
                </div>

                <!-- Service Details -->
                <div>
                    <label for="service_details" class="block text-xs font-semibold text-gray-700 tracking-wide">Service History / Detailed Responsibilities</label>
                    <textarea name="service_details" id="service_details" rows="5" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">{{ old('service_details', $officer->service_details) }}</textarea>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('officers.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
