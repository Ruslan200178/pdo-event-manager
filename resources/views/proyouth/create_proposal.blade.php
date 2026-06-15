@extends('layouts.app')

@section('title', 'Add Project Proposal Entry')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add Project Proposal Entry</h1>
            <p class="text-xs text-gray-500">Record a new participant for the Project Proposal Competition.</p>
        </div>
        <div>
            <a href="{{ route('proyouth.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('proyouth.proposal.store') }}" method="POST">
            @csrf
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 tracking-wide">Full Name</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- NIC Number -->
                    <div>
                        <label for="nic_number" class="block text-xs font-semibold text-gray-700 tracking-wide">NIC Number</label>
                        <input type="text" name="nic_number" id="nic_number" required value="{{ old('nic_number') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-xs font-semibold text-gray-700 tracking-wide">Age</label>
                        <input type="number" name="age" id="age" required min="1" max="120" value="{{ old('age') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- DS Division -->
                    <div>
                        <label for="ds_division" class="block text-xs font-semibold text-gray-700 tracking-wide">DS Division</label>
                        <input type="text" name="ds_division" id="ds_division" required value="{{ old('ds_division') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Institute / School -->
                    <div>
                        <label for="institute_school" class="block text-xs font-semibold text-gray-700 tracking-wide">Institute / School</label>
                        <input type="text" name="institute_school" id="institute_school" required value="{{ old('institute_school') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-semibold text-gray-700 tracking-wide">Address</label>
                        <input type="text" name="address" id="address" required value="{{ old('address') }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>

                    <!-- Proposal Link -->
                    <div>
                        <label for="proposal_link" class="block text-xs font-semibold text-gray-700 tracking-wide">Proposal Link <span class="text-gray-400 font-normal">(PDF/Document Shared Url)</span></label>
                        <input type="url" name="proposal_link" id="proposal_link" value="{{ old('proposal_link') }}" placeholder="https://..." class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('proyouth.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Entry</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
