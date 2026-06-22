@extends('layouts.app')

@section('title', 'Edit Allocation Entry')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Allocation Entry</h1>
            <p class="text-xs text-gray-500 mt-1">Update allocation for the 4i Program.</p>
        </div>
        <a href="{{ route('fouri.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('fouri.allocations.update', $allocation->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div class="space-y-1.5">
                    <label for="date" class="block text-xs font-semibold text-gray-700">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date', $allocation->date) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Division Name -->
                <div class="space-y-1.5">
                    <label for="division_name" class="block text-xs font-semibold text-gray-700">Division Name <span class="text-red-500">*</span></label>
                    <select name="division_name" id="division_name" required
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors">
                        <option value="">Select Division</option>
                        @foreach([
                            'Mutur',
                            'Kinniya',
                            'Verugal',
                            'Seruwela',
                            'Kanthale',
                            'Thambalagamam',
                            'Town and Gravets',
                            'Morawewa',
                            'Gomarankadawela',
                            'Kuchcheveli',
                            'Padavisiripure'
                        ] as $div)
                            <option value="{{ $div }}" {{ old('division_name', $allocation->division_name) == $div ? 'selected' : '' }}>{{ $div }}</option>
                        @endforeach
                    </select>
                    @error('division_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div class="space-y-1.5">
                    <label for="amount" class="block text-xs font-semibold text-gray-700">Amount (LKR) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $allocation->amount) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="Enter amount">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Type -->
                <div class="space-y-1.5">
                    <label for="program_type" class="block text-xs font-semibold text-gray-700">Program Type <span class="text-red-500">*</span></label>
                    <input type="text" name="program_type" id="program_type" value="{{ old('program_type', $allocation->program_type) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="Enter program type">
                    @error('program_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Participants Count -->
                <div class="space-y-1.5">
                    <label for="participants_count" class="block text-xs font-semibold text-gray-700">Participants Count <span class="text-red-500">*</span></label>
                    <input type="number" name="participants_count" id="participants_count" value="{{ old('participants_count', $allocation->participants_count) }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                           placeholder="Enter number of participants">
                    @error('participants_count')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purpose -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="purpose" class="block text-xs font-semibold text-gray-700">Purpose <span class="text-red-500">*</span></label>
                    <textarea name="purpose" id="purpose" rows="4" required
                              class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500 transition-colors"
                              placeholder="Enter purpose of the allocation...">{{ old('purpose', $allocation->purpose) }}</textarea>
                    @error('purpose')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Images Upload -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="images" class="block text-xs font-semibold text-gray-700">Images (optional)</label>
                    <input type="file" name="images[]" id="images" multiple class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500" />
                    @error('images.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Existing Images Gallery -->
                @if($allocation->images && $allocation->images->count() > 0)
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700">Current Images</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2">
                            @foreach($allocation->images as $img)
                                <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm group aspect-video">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Allocation Image" class="object-cover w-full h-full" />
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" 
                                                onclick="if(confirm('Are you sure you want to delete this image?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }"
                                                class="px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-[10px] font-bold transition-colors">
                                            <i class="fa-solid fa-trash-can mr-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-sm font-semibold shadow-sm transition-all duration-200">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Update Allocation</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Delete Forms -->
@if($allocation->images && $allocation->images->count() > 0)
    @foreach($allocation->images as $img)
        <form id="delete-img-{{ $img->id }}" action="{{ route('fouri.allocations.images.destroy', $img->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif
@endsection
