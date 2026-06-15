@extends('layouts.app')

@section('title', 'NPC Program Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="px-2.5 py-1 bg-govblue-50 text-govblue-800 text-xs font-bold rounded-lg uppercase tracking-wider">National Productivity Competition</span>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight mt-1">Program Details: {{ $program->vote_number }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('npc.index') }}" class="px-3.5 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>Back
            </a>
            <a href="{{ route('npc.report', $program->id) }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-file-invoice"></i>Report View
            </a>
            <a href="{{ route('npc.edit', $program->id) }}" class="px-3.5 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-pen"></i>Edit
            </a>
        </div>
    </div>

    <!-- Data Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Key Metrics Panel -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-6 md:col-span-1">
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Financial Summary</h3>
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-2">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Allocated Budget</p>
                    <p class="text-2xl font-black text-gray-800">LKR {{ number_format($program->amount, 2) }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Received?</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $program->received_allocation }}</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Vote Number</p>
                        <p class="text-xs font-bold text-gray-800 mt-0.5 truncate">{{ $program->vote_number }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 border-t border-gray-100 pt-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Timeline & Venue</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-gray-500"><i class="fa-solid fa-calendar-day text-xs"></i></span>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Conducted Date</p>
                            <p class="text-xs font-bold text-gray-800">{{ $program->conducted_date }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-gray-500"><i class="fa-solid fa-location-dot text-xs"></i></span>
                        <div class="overflow-hidden">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Place / Venue</p>
                            <p class="text-xs font-bold text-gray-800 truncate" title="{{ $program->place }}">{{ $program->place }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants & Placements Stats -->
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm space-y-6 md:col-span-2">
            <!-- Participants Breakdown -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Participants Distribution</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl text-center">
                        <p class="text-[9px] text-blue-600 font-bold uppercase">Public Sector</p>
                        <p class="text-xl font-bold text-blue-900 mt-1">{{ $program->participants_public }}</p>
                    </div>
                    <div class="p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl text-center">
                        <p class="text-[9px] text-indigo-600 font-bold uppercase">School Sector</p>
                        <p class="text-xl font-bold text-indigo-900 mt-1">{{ $program->participants_school }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center">
                        <p class="text-[9px] text-slate-500 font-bold uppercase">Private Sector</p>
                        <p class="text-xl font-bold text-slate-800 mt-1">{{ $program->participants_private }}</p>
                    </div>
                </div>
                <div class="p-3 bg-govblue-900 text-white rounded-xl flex justify-between items-center text-xs font-bold px-6">
                    <span>Total Program Participants</span>
                    <span>{{ $program->participants_public + $program->participants_school + $program->participants_private }}</span>
                </div>
            </div>

            <!-- Public Sector Detailed statistics -->
            <div class="space-y-4 border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Public Sector Applications & Awards</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Total Applications Received:</span>
                        <span class="font-bold text-gray-800">{{ $program->public_applications_count }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Selected Applications:</span>
                        <span class="font-bold text-emerald-600">{{ $program->public_selected_count }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Number of Special commentation:</span>
                        <span class="font-bold text-gray-800">{{ $program->special_commentation_count }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Number of Commentation:</span>
                        <span class="font-bold text-gray-800">{{ $program->commentation_count }}</span>
                    </div>
                </div>
            </div>

            <!-- School Sector Detailed statistics -->
            <div class="space-y-4 border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">School Sector Applications &amp; Awards</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Total Applications Received:</span>
                        <span class="font-bold text-gray-800">{{ $program->school_applications_count }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Selected Applications:</span>
                        <span class="font-bold text-emerald-600">{{ $program->school_selected_count }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Number of Special commentation:</span>
                        <span class="font-bold text-gray-800">{{ $program->school_special_commentation_count }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Number of Commentation:</span>
                        <span class="font-bold text-gray-800">{{ $program->school_commentation_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Public Sector Placements -->
            <div class="space-y-4 border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Public Sector Placements</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-3 bg-amber-50 border border-amber-100 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-amber-700 font-bold uppercase block">1st Place</span>
                        <span class="text-lg font-bold text-amber-900">{{ $program->place_1st_count }}</span>
                        @if(trim($program->public_place_1st_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->public_place_1st_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                    <div class="p-3 bg-slate-100 border border-slate-200 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-slate-600 font-bold uppercase block">2nd Place</span>
                        <span class="text-lg font-bold text-slate-800">{{ $program->place_2nd_count }}</span>
                        @if(trim($program->public_place_2nd_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->public_place_2nd_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-orange-700 font-bold uppercase block">3rd Place</span>
                        <span class="text-lg font-bold text-orange-900">{{ $program->place_3rd_count }}</span>
                        @if(trim($program->public_place_3rd_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->public_place_3rd_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                </div>
            </div>

            <!-- School Sector Placements -->
            <div class="space-y-4 border-t border-gray-100 pt-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">School Sector Placements</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-3 bg-amber-50 border border-amber-100 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-amber-700 font-bold uppercase block">1st Place</span>
                        <span class="text-lg font-bold text-amber-900">{{ $program->school_place_1st_count }}</span>
                        @if(trim($program->school_place_1st_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->school_place_1st_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                    <div class="p-3 bg-slate-100 border border-slate-200 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-slate-600 font-bold uppercase block">2nd Place</span>
                        <span class="text-lg font-bold text-slate-800">{{ $program->school_place_2nd_count }}</span>
                        @if(trim($program->school_place_2nd_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->school_place_2nd_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl text-center space-y-1">
                        <span class="text-[9px] text-orange-700 font-bold uppercase block">3rd Place</span>
                        <span class="text-lg font-bold text-orange-900">{{ $program->school_place_3rd_count }}</span>
                        @if(trim($program->school_place_3rd_institute))
<ul class="list-disc list-inside text-[10px] text-gray-500 mt-1">
@foreach(array_filter(array_map('trim', explode(',', $program->school_place_3rd_institute))) as $inst)
<li>{{ $inst }}</li>
@endforeach
</ul>
@else
<span class="text-[10px] text-gray-500 block mt-1 font-semibold leading-tight">N/A</span>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-gray-800 tracking-tight">Event Photo Album</h3>
            <span class="text-xs text-gray-400 font-semibold">{{ count($program->galleryImages) }} Photos uploaded</span>
        </div>

        @if(count($program->galleryImages) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($program->galleryImages as $photo)
                    <div class="rounded-xl overflow-hidden border border-gray-150 shadow-sm aspect-video bg-gray-50 hover:opacity-95 transition-opacity cursor-pointer" onclick="openLightbox({{ $loop->index }})">
                        <img src="{{ asset($photo->file_path) }}" alt="NPC photo" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400 text-xs">
                <i class="fa-solid fa-images text-2xl mb-2 block text-gray-300"></i>
                No photos uploaded for this criteria program.
            </div>
        @endif
    </div>
</div>

<!-- Simple Lightbox Modal -->
<div id="lightbox" class="hidden fixed inset-0 bg-black/95 z-50 flex flex-col items-center justify-center p-4">
    <!-- Download button (Top-Left) -->
    <a id="lightbox-download" href="" download class="absolute top-4 left-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Download Image">
        <i class="fa-solid fa-download"></i>
    </a>

    <!-- Close button (Top-Right) -->
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Close">
        <i class="fa-solid fa-xmark"></i>
    </button>
    
    <!-- Prev button -->
    <button onclick="prevImage()" class="absolute left-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    
    <!-- Next button -->
    <button onclick="nextImage()" class="absolute right-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <img id="lightbox-img" src="" class="max-h-[70vh] max-w-[70vw] object-contain rounded shadow-2xl">
    <p id="lightbox-caption" class="text-white text-xs mt-4 font-semibold text-center max-w-[80vw]"></p>
</div>

<script>
    let currentImageIndex = 0;
    const galleryImages = [
        @foreach($program->galleryImages as $photo)
        { src: "{{ asset($photo->file_path) }}", caption: "{{ $photo->caption }}" },
        @endforeach
    ];

    function openLightbox(index) {
        currentImageIndex = index;
        updateLightbox();
        document.getElementById('lightbox').classList.remove('hidden');
    }

    function updateLightbox() {
        if (galleryImages.length === 0) return;
        if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
        if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;
        
        const img = galleryImages[currentImageIndex];
        if (img) {
            document.getElementById('lightbox-img').src = img.src;
            document.getElementById('lightbox-caption').textContent = img.caption || '';
            const downloadBtn = document.getElementById('lightbox-download');
            if (downloadBtn) {
                downloadBtn.href = img.src;
            }
        }
    }

    function nextImage() {
        currentImageIndex++;
        updateLightbox();
    }

    function prevImage() {
        currentImageIndex--;
        updateLightbox();
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
    }

    // Add arrow key listener
    document.addEventListener('keydown', function(event) {
        const lightbox = document.getElementById('lightbox');
        if (lightbox && !lightbox.classList.contains('hidden')) {
            if (event.key === 'ArrowRight') {
                nextImage();
            } else if (event.key === 'ArrowLeft') {
                prevImage();
            } else if (event.key === 'Escape') {
                closeLightbox();
            }
        }
    });
</script>
@endsection
