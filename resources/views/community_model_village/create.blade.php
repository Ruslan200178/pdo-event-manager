@extends('layouts.app')

@section('title', 'Add CMV Entry')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add Model Village Entry</h1>
            <p class="text-xs text-gray-500">Record a new Community Model Village Program development plan.</p>
        </div>
        <div>
            <a href="{{ route('cmv.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('cmv.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 md:p-8 space-y-8">
                <!-- Section 1: Financial & Basic -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Financial & Identification Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


                        <!-- District Allocation -->
                        <div>
                            <label for="district_allocation" class="block text-xs font-semibold text-gray-700 tracking-wide">District Budget Allocation (LKR)</label>
                            <input type="number" name="district_allocation" id="district_allocation" required step="0.01" min="0" placeholder="0.00" value="{{ old('district_allocation') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Vote Number -->
                        <div>
                            <label for="vote_number" class="block text-xs font-semibold text-gray-700 tracking-wide">Vote Number</label>
                            <input type="text" name="vote_number" id="vote_number" required placeholder="V-2026-CMV-XX" value="{{ old('vote_number') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Used Amount -->
                        <div>
                            <label for="amount" class="block text-xs font-semibold text-gray-700 tracking-wide">Amount Spent (LKR)</label>
                            <input type="number" name="amount" id="amount" required step="0.01" min="0" placeholder="0.00" value="{{ old('amount') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-xs font-semibold text-gray-700 tracking-wide">Entry / Action Date</label>
                            <input type="date" name="date" id="date" required value="{{ old('date', '2026-06-13') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Purpose -->
                        <div class="md:col-span-2">
                            <label for="purpose" class="block text-xs font-semibold text-gray-700 tracking-wide">Purpose / Objective</label>
                            <input type="text" name="purpose" id="purpose" required placeholder="To establish organic model garden and small business coaching..." value="{{ old('purpose') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Location & Staff -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Location & Contact Officers</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Division Name -->
                        <div>
                            <label for="division_name" class="block text-xs font-semibold text-gray-700 tracking-wide">DS Division Name</label>
                            <select name="division_name" id="division_name" required class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 bg-white">
                                <option value="" disabled {{ old('division_name') ? '' : 'selected' }}>Select DS Division</option>
                                <option value="Mutur" {{ old('division_name') == 'Mutur' ? 'selected' : '' }}>Mutur</option>
                                <option value="Kinniya" {{ old('division_name') == 'Kinniya' ? 'selected' : '' }}>Kinniya</option>
                                <option value="Verugal" {{ old('division_name') == 'Verugal' ? 'selected' : '' }}>Verugal</option>
                                <option value="Seruwela" {{ old('division_name') == 'Seruwela' ? 'selected' : '' }}>Seruwela</option>
                                <option value="Kanthale" {{ old('division_name') == 'Kanthale' ? 'selected' : '' }}>Kanthale</option>
                                <option value="Thambalagamam" {{ old('division_name') == 'Thambalagamam' ? 'selected' : '' }}>Thambalagamam</option>
                                <option value="Town and Gravets" {{ old('division_name') == 'Town and Gravets' ? 'selected' : '' }}>Town and Gravets</option>
                                <option value="Morawewa" {{ old('division_name') == 'Morawewa' ? 'selected' : '' }}>Morawewa</option>
                                <option value="Gomarankadawela" {{ old('division_name') == 'Gomarankadawela' ? 'selected' : '' }}>Gomarankadawela</option>
                                <option value="Kuchcheveli" {{ old('division_name') == 'Kuchcheveli' ? 'selected' : '' }}>Kuchcheveli</option>
                                <option value="padavisiripure" {{ old('division_name') == 'padavisiripure' ? 'selected' : '' }}>padavisiripure</option>
                            </select>
                        </div>
                        <!-- GN Division as text input -->
                        <div>
                            <label for="gn_division" class="block text-xs font-semibold text-gray-700 tracking-wide">Grama Niladhari (GN) Division</label>
                            <input type="text" name="gn_division" id="gn_division" required placeholder="Enter GN Division" value="{{ old('gn_division') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 bg-white" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Village Name -->
                        <div>
                            <label for="village" class="block text-xs font-semibold text-gray-700 tracking-wide">Village Name</label>
                            <input type="text" name="village" id="village" required placeholder="Malabe South" value="{{ old('village') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Contacted Staff -->
                        <div>
                            <label for="contacted_staff" class="block text-xs font-semibold text-gray-700 tracking-wide">Contacted Divisional Staff</label>
                            <input type="text" name="contacted_staff" id="contacted_staff" required placeholder="Mr. Gunasinghe (GN Officer)" value="{{ old('contacted_staff') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Seminars & Ceremonies dates -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Awareness & Ceremony Timelines</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Awareness Date -->
                        <div>
                            <label for="awareness_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Awareness Program Date</label>
                            <input type="date" name="awareness_date" id="awareness_date" value="{{ old('awareness_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Stakeholder Awareness Date -->
                        <div>
                            <label for="stakeholder_awareness_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Stakeholder Awareness Date</label>
                            <input type="date" name="stakeholder_awareness_date" id="stakeholder_awareness_date" value="{{ old('stakeholder_awareness_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Participants Count -->
                        <div>
                            <label for="participants_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Awareness Participants Count</label>
                            <input type="number" name="participants_count" id="participants_count" required min="0" value="{{ old('participants_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Launching Ceremony Date -->
                        <div>
                            <label for="launching_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Launching Ceremony Date</label>
                            <input type="date" name="launching_date" id="launching_date" value="{{ old('launching_date') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Ceremony Participants Count -->
                        <div>
                            <label for="ceremony_participants_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Ceremony Participants Count</label>
                            <input type="number" name="ceremony_participants_count" id="ceremony_participants_count" required min="0" value="{{ old('ceremony_participants_count', 0) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
<!-- Image Upload -->
<div class="mt-6">
    <label for="images" class="block text-xs font-semibold text-gray-700 tracking-wide">Upload Event Images</label>
    <input type="file" name="images[]" id="images" multiple accept="image/*" class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
</div>
                </div>
            </div>

            <!-- Form Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('cmv.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Entry</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
