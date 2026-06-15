@extends('layouts.app')

@section('title', 'Edit NPC criteria Program')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit NPC Criteria Program</h1>
            <p class="text-xs text-gray-500">Modify the recorded Criteria Program for the National Productivity Competition.</p>
        </div>
        <div>
            <a href="{{ route('npc.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <form action="{{ route('npc.update', $program->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-8">
                <!-- Section 1: Financial & Basic details -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Basic & Financial Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Received Allocation -->
                        <div>
                            <label for="received_allocation" class="block text-xs font-semibold text-gray-700 tracking-wide">Received Allocation?</label>
                            <select name="received_allocation" id="received_allocation" required class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                                <option value="Yes" {{ old('received_allocation', $program->received_allocation) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('received_allocation', $program->received_allocation) == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Vote Number -->
                        <div>
                            <label for="vote_number" class="block text-xs font-semibold text-gray-700 tracking-wide">Vote Number</label>
                            <input type="text" name="vote_number" id="vote_number" required placeholder="V-2026-NPC-XX" value="{{ old('vote_number', $program->vote_number) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-xs font-semibold text-gray-700 tracking-wide">Amount Allocation (LKR)</label>
                            <input type="number" name="amount" id="amount" required step="0.01" min="0" placeholder="0.00" value="{{ old('amount', $program->amount) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Conducted Date -->
                        <div>
                            <label for="conducted_date" class="block text-xs font-semibold text-gray-700 tracking-wide">Conducted Date</label>
                            <input type="date" name="conducted_date" id="conducted_date" required value="{{ old('conducted_date', $program->conducted_date) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Place -->
                        <div>
                            <label for="place" class="block text-xs font-semibold text-gray-700 tracking-wide">Place / Venue</label>
                            <input type="text" name="place" id="place" required placeholder="Divisional Secretariat Auditorium" value="{{ old('place', $program->place) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Participants categories -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Participants Breakdowns</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Public Sector -->
                        <div>
                            <label for="participants_public" class="block text-xs font-semibold text-gray-700 tracking-wide">Public Sector Count</label>
                            <input type="number" name="participants_public" id="participants_public" required min="0" value="{{ old('participants_public', $program->participants_public) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- School -->
                        <div>
                            <label for="participants_school" class="block text-xs font-semibold text-gray-700 tracking-wide">School Sector Count</label>
                            <input type="number" name="participants_school" id="participants_school" required min="0" value="{{ old('participants_school', $program->participants_school) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Private Sector -->
                        <div>
                            <label for="participants_private" class="block text-xs font-semibold text-gray-700 tracking-wide">Private Sector Count</label>
                            <input type="number" name="participants_private" id="participants_private" required min="0" value="{{ old('participants_private', $program->participants_private) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                @php
                    $publicInstitutes = [
                        'Urban Council – Kinniya',
                        'Agrarian Service Centre Nilaveli',
                        'Divisional Secretariat – Morawewa',
                        'Divisional Secretariat – Muttur',
                        'Divisional Secretariat – Thambalagamuwa',
                        'Naval Hospital Trincomalee',
                        'Department of Agrarian Development – Trincomalee',
                        'Deputy Chief Secretary – Personnel and Training, Eastern Province',
                        'Management Development Training Unit, Eastern Province',
                        'Ministry of Education, Eastern Province',
                        'District Secretariat – Trincomalee',
                        'Divisional Secretariat – Verugal',
                    ];
                    $schoolInstitutes = [
                        'T/Mu/Ashraff Vidyalayam',
                        'T/Methodist Girls\' College',
                        'T/T/Kanniya Ravaneswaran Tamil Vidyalayam',
                        'T/Sri Shanmuga Hindu Ladies\' College',
                        'T/R K M Sri Koneswara Hindu College',
                        'T/T/Al-Minhaj Muslim Maha Vidyalayam',
                        'T/T/Orr\'s Hill Vivekananda College',
                    ];

                    $selectedPublic1st = array_filter(array_map('trim', explode(',', $program->public_place_1st_institute ?? '')));
                    $selectedPublic2nd = array_filter(array_map('trim', explode(',', $program->public_place_2nd_institute ?? '')));
                    $selectedPublic3rd = array_filter(array_map('trim', explode(',', $program->public_place_3rd_institute ?? '')));
                    $selectedSchool1st = array_filter(array_map('trim', explode(',', $program->school_place_1st_institute ?? '')));
                    $selectedSchool2nd = array_filter(array_map('trim', explode(',', $program->school_place_2nd_institute ?? '')));
                    $selectedSchool3rd = array_filter(array_map('trim', explode(',', $program->school_place_3rd_institute ?? '')));
                @endphp

                <!-- Section 3: Public Sector Applications & Awards -->
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Public Sector Applications & Awards</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Applications Count -->
                        <div>
                            <label for="public_applications_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Applications</label>
                            <input type="number" name="public_applications_count" id="public_applications_count" required min="0" value="{{ old('public_applications_count', $program->public_applications_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Selected Applications -->
                        <div>
                            <label for="public_selected_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Selected Applications Count</label>
                            <input type="number" name="public_selected_count" id="public_selected_count" required min="0" value="{{ old('public_selected_count', $program->public_selected_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- 1st Place -->
                        <div>
                            <label for="place_1st_count" class="block text-xs font-semibold text-gray-700 tracking-wide">1st Place Count</label>
                            <input type="number" name="place_1st_count" id="place_1st_count" required min="0" value="{{ old('place_1st_count', $program->place_1st_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Institutes (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($publicInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="public_place_1st_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('public_place_1st_institutes', $selectedPublic1st)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 2nd Place -->
                        <div>
                            <label for="place_2nd_count" class="block text-xs font-semibold text-gray-700 tracking-wide">2nd Place Count</label>
                            <input type="number" name="place_2nd_count" id="place_2nd_count" required min="0" value="{{ old('place_2nd_count', $program->place_2nd_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Institutes (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($publicInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="public_place_2nd_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('public_place_2nd_institutes', $selectedPublic2nd)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 3rd Place -->
                        <div>
                            <label for="place_3rd_count" class="block text-xs font-semibold text-gray-700 tracking-wide">3rd Place Count</label>
                            <input type="number" name="place_3rd_count" id="place_3rd_count" required min="0" value="{{ old('place_3rd_count', $program->place_3rd_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Institutes (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($publicInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="public_place_3rd_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('public_place_3rd_institutes', $selectedPublic3rd)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Number of Special commentation -->
                        <div>
                            <label for="special_commentation_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Special commentation</label>
                            <input type="number" name="special_commentation_count" id="special_commentation_count" required min="0" value="{{ old('special_commentation_count', $program->special_commentation_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>

                        <!-- Number of Commentation -->
                        <div>
                            <label for="commentation_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Commentation</label>
                            <input type="number" name="commentation_count" id="commentation_count" required min="0" value="{{ old('commentation_count', $program->commentation_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 4: School Sector Applications & Awards -->
                <div class="space-y-6 border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">School Sector Applications & Awards</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Applications Count -->
                        <div>
                            <label for="school_applications_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Applications</label>
                            <input type="number" name="school_applications_count" id="school_applications_count" required min="0" value="{{ old('school_applications_count', $program->school_applications_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                        <!-- Selected Applications -->
                        <div>
                            <label for="school_selected_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Selected Applications Count</label>
                            <input type="number" name="school_selected_count" id="school_selected_count" required min="0" value="{{ old('school_selected_count', $program->school_selected_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- 1st Place -->
                        <div>
                            <label for="school_place_1st_count" class="block text-xs font-semibold text-gray-700 tracking-wide">1st Place Count</label>
                            <input type="number" name="school_place_1st_count" id="school_place_1st_count" required min="0" value="{{ old('school_place_1st_count', $program->school_place_1st_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Schools (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($schoolInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="school_place_1st_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('school_place_1st_institutes', $selectedSchool1st)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 2nd Place -->
                        <div>
                            <label for="school_place_2nd_count" class="block text-xs font-semibold text-gray-700 tracking-wide">2nd Place Count</label>
                            <input type="number" name="school_place_2nd_count" id="school_place_2nd_count" required min="0" value="{{ old('school_place_2nd_count', $program->school_place_2nd_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Schools (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($schoolInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="school_place_2nd_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('school_place_2nd_institutes', $selectedSchool2nd)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 3rd Place -->
                        <div>
                            <label for="school_place_3rd_count" class="block text-xs font-semibold text-gray-700 tracking-wide">3rd Place Count</label>
                            <input type="number" name="school_place_3rd_count" id="school_place_3rd_count" required min="0" value="{{ old('school_place_3rd_count', $program->school_place_3rd_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mt-2">Winner Schools (Select multiple)</label>
                            <div class="mt-1 border border-gray-300 rounded-xl p-3 max-h-36 overflow-y-auto space-y-2 bg-gray-50/50 shadow-inner">
                                @foreach($schoolInstitutes as $institute)
                                    <label class="flex items-start gap-2 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="school_place_3rd_institutes[]" value="{{ $institute }}" {{ in_array($institute, old('school_place_3rd_institutes', $selectedSchool3rd)) ? 'checked' : '' }} class="rounded border-gray-300 text-govblue-600 focus:ring-govblue-500 mt-0.5">
                                        <span>{{ $institute }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Number of Special commentation (School) -->
                        <div>
                            <label for="school_special_commentation_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Special commentation</label>
                            <input type="number" name="school_special_commentation_count" id="school_special_commentation_count" required min="0" value="{{ old('school_special_commentation_count', $program->school_special_commentation_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                        <!-- Number of Commentation (School) -->
                        <div>
                            <label for="school_commentation_count" class="block text-xs font-semibold text-gray-700 tracking-wide">Number of Commentation</label>
                            <input type="number" name="school_commentation_count" id="school_commentation_count" required min="0" value="{{ old('school_commentation_count', $program->school_commentation_count) }}" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 5: Program Photos -->
                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-govblue-900 border-b border-gray-100 pb-2 uppercase tracking-wider">Program Photos</h3>
                    <div>
                        <label for="photos" class="block text-xs font-semibold text-gray-700 tracking-wide">Add More Photos <span class="text-gray-400 font-normal">(Select multiple images up to 5MB each)</span></label>
                        <input type="file" name="photos[]" id="photos" accept="image/*" multiple class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl p-1">
                        <p class="text-[10px] text-gray-400 mt-1">You can select multiple images to upload. Supported formats: JPEG, PNG, JPG, GIF (Max 5MB each).</p>
                    </div>
                </div>
            </div>

            <!-- Form Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('npc.index') }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors duration-150">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Existing photos gallery deletion -->
    @if(count($program->galleryImages) > 0)
        <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 mt-6">
            <h3 class="text-sm font-bold text-gray-800 tracking-tight mb-4">Existing Program Photos</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($program->galleryImages as $photo)
                    <div class="relative group rounded-xl overflow-hidden border border-gray-150 shadow-sm aspect-video bg-gray-100">
                        <img src="{{ asset($photo->file_path) }}" alt="NPC photo" class="w-full h-full object-cover">
                        <!-- overlay delete -->
                        <div class="absolute inset-0 bg-black/45 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <form action="{{ route('gallery.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Delete this image from the gallery?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition-colors shadow flex items-center gap-1.5">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
