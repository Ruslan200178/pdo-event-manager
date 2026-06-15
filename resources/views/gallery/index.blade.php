@extends('layouts.app')

@section('title', 'Image Gallery')

@section('content')
@php
    $typeNames = [
        'national_productivity' => 'National Productivity Competition',
        'model_village' => 'Community Model Village Programs',
        'citizen_mirror' => 'Citizen Mirror',
        'proyouth' => 'ProYouth Program',
        'five_s' => '5S Certification',
        'certification_course' => 'Certification Courses',
        'training' => 'Training Programs',
        'general' => 'General Media'
    ];
    $typeIcons = [
        'national_productivity' => 'fa-award',
        'model_village' => 'fa-house-chimney',
        'citizen_mirror' => 'fa-id-card',
        'proyouth' => 'fa-bolt',
        'five_s' => 'fa-certificate',
        'certification_course' => 'fa-graduation-cap',
        'training' => 'fa-chalkboard-user',
        'general' => 'fa-image'
    ];
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Image Gallery</h1>
            <p class="text-xs text-gray-500">View and manage media uploads and event photos categorized by program albums.</p>
        </div>
        <div>
            <button onclick="toggleUploadForm()" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload Image</span>
            </button>
        </div>
    </div>

    <!-- Upload Form Card (Expandable) -->
    <div id="upload-card" class="hidden bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden transition-all duration-300">
        <div class="p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-file-image text-govblue-900"></i>
                <span>Upload New Media Image</span>
            </h3>
            <form action="{{ route('gallery.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="images" class="block text-xs font-semibold text-gray-700 tracking-wide">Select Image Files</label>
                        <input type="file" name="images[]" id="images" required accept="image/*" multiple class="mt-1.5 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-govblue-50 file:text-govblue-900 hover:file:bg-govblue-100 border border-gray-300 rounded-xl">
                    </div>
                    <div>
                        <label for="program_type" class="block text-xs font-semibold text-gray-700 tracking-wide">Category / Module Type</label>
                        <select name="program_type" id="program_type" class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                            <option value="national_productivity">National Productivity</option>
                            <option value="model_village">Model Village Program</option>
                            <option value="citizen_mirror">Citizen Mirror</option>
                            <option value="proyouth">ProYouth Program</option>
                            <option value="five_s">5S Certification</option>
                            <option value="certification_course">Certification Course</option>
                            <option value="training">Training Program</option>
                            <option value="general">General Media</option>
                        </select>
                    </div>
                    <div>
                        <label for="caption" class="block text-xs font-semibold text-gray-700 tracking-wide">Image Caption / Description</label>
                        <input type="text" name="caption" id="caption" placeholder="Enter brief caption..." class="mt-1.5 block w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-govblue-500 focus:border-govblue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 border-t border-gray-50 pt-4">
                    <button type="button" onclick="toggleUploadForm()" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-55 transition-colors">Cancel</button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 shadow-sm transition-colors">
                        <i class="fa-solid fa-upload"></i>
                        <span>Start Upload</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- LEVEL 1: Category Folders (no type selected)                  --}}
    {{-- ============================================================ --}}
    @if(!$selectedType)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($categories as $cat)
                @php
                    $catName = $typeNames[$cat->program_type] ?? ucwords(str_replace('_', ' ', $cat->program_type));
                    $catIcon = $typeIcons[$cat->program_type] ?? 'fa-folder';
                @endphp
                <a href="{{ route('gallery.index', ['type' => $cat->program_type]) }}" class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6 hover:shadow-md hover:border-govblue-300 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-govblue-50/50 flex items-center justify-center text-govblue-900 group-hover:bg-govblue-900 group-hover:text-white transition-all duration-200 mb-4 shadow-sm">
                        <i class="fa-solid fa-folder text-3xl group-hover:hidden"></i>
                        <i class="fa-solid fa-folder-open text-3xl hidden group-hover:block"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-govblue-900 transition-colors">{{ $catName }}</h3>
                    <p class="text-xs text-gray-400 mt-1 font-semibold">{{ $cat->image_count }} {{ Str::plural('Image', $cat->image_count) }}</p>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-gray-150 shadow-sm p-12 text-center text-gray-400 text-xs">
                    <i class="fa-solid fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                    No media albums created yet. Upload an image to start.
                </div>
            @endforelse
        </div>

    {{-- ============================================================ --}}
    {{-- LEVEL 2: Event sub-folders inside a category                  --}}
    {{-- ============================================================ --}}
    @elseif($events && !$selectedEvent)
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold">
            <a href="{{ route('gallery.index') }}" class="hover:text-govblue-900 transition-colors">Albums</a>
            <i class="fa-solid fa-chevron-right text-[8px] text-gray-300"></i>
            <span class="text-gray-800">{{ $typeNames[$selectedType] ?? ucwords(str_replace('_', ' ', $selectedType)) }}</span>
        </div>

        <!-- Back + Title -->
        <div class="flex items-center gap-3">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center justify-center p-2 bg-white border border-gray-250 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors shadow-sm" title="Back to Albums">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-800 tracking-tight">{{ $typeNames[$selectedType] ?? ucwords(str_replace('_', ' ', $selectedType)) }}</h2>
                <p class="text-xs text-gray-400">Select an event to view its photos. Each event shows when and where it happened.</p>
            </div>
        </div>

        <!-- Event Sub-folders -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($events as $event)
                @php
                    $details = $event->details;
                    $eventTitle = $details ? $details->title : ($event->caption ?: 'Event #' . ($event->program_id ?? 'General'));
                    $eventSubtitle = $details ? $details->subtitle : '';
                    $eventDate = $details ? $details->date : '';
                    $eventPlace = $details ? $details->place : '';
                    $linkParams = ['type' => $selectedType];
                    if ($event->program_id) {
                        $linkParams['event'] = $event->program_id;
                    }
                @endphp
                <a href="{{ route('gallery.index', $linkParams) }}" class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden hover:shadow-md hover:border-govblue-300 transition-all duration-200 group">
                    <!-- Top color bar -->
                    <div class="h-1.5 bg-gradient-to-r from-govblue-600 to-govblue-900"></div>
                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-govblue-50 flex items-center justify-center text-govblue-700 group-hover:bg-govblue-900 group-hover:text-white transition-all duration-200 flex-shrink-0">
                                <i class="fa-solid {{ $typeIcons[$selectedType] ?? 'fa-folder' }} text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 text-sm line-clamp-1 group-hover:text-govblue-900 transition-colors">{{ $eventTitle }}</h3>
                                @if($eventSubtitle)
                                    <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-1">{{ $eventSubtitle }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-2 flex-wrap">
                                    @if($eventDate)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-gray-400 font-semibold">
                                            <i class="fa-regular fa-calendar text-[9px]"></i>
                                            {{ $eventDate }}
                                        </span>
                                    @endif
                                    @if($eventPlace)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-gray-400 font-semibold">
                                            <i class="fa-solid fa-location-dot text-[9px]"></i>
                                            {{ $eventPlace }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 text-[10px] text-govblue-600 font-bold bg-govblue-50 px-2 py-0.5 rounded-full border border-govblue-100">
                                        <i class="fa-solid fa-images text-[9px]"></i>
                                        {{ $event->image_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    {{-- ============================================================ --}}
    {{-- LEVEL 3: Images grid (inside an event OR general direct view) --}}
    {{-- ============================================================ --}}
    @elseif($images)
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold">
            <a href="{{ route('gallery.index') }}" class="hover:text-govblue-900 transition-colors">Albums</a>
            <i class="fa-solid fa-chevron-right text-[8px] text-gray-300"></i>
            <a href="{{ route('gallery.index', ['type' => $selectedType]) }}" class="hover:text-govblue-900 transition-colors">{{ $typeNames[$selectedType] ?? ucwords(str_replace('_', ' ', $selectedType)) }}</a>
            @if($eventInfo)
                <i class="fa-solid fa-chevron-right text-[8px] text-gray-300"></i>
                <span class="text-gray-800">{{ $eventInfo->title }}</span>
            @endif
        </div>

        <!-- Back + Title -->
        <div class="flex items-center gap-3">
            @php
                $backUrl = $selectedEvent ? route('gallery.index', ['type' => $selectedType]) : route('gallery.index');
            @endphp
            <a href="{{ $backUrl }}" class="inline-flex items-center justify-center p-2 bg-white border border-gray-250 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors shadow-sm" title="Go Back">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </a>
            <div>
                @if($eventInfo)
                    <h2 class="text-lg font-bold text-gray-800 tracking-tight">{{ $eventInfo->title }}</h2>
                    <p class="text-xs text-gray-400">
                        {{ $eventInfo->subtitle }}
                        @if($eventInfo->date) &bull; {{ $eventInfo->date }} @endif
                    </p>
                @else
                    <h2 class="text-lg font-bold text-gray-800 tracking-tight">{{ $typeNames[$selectedType] ?? ucwords(str_replace('_', ' ', $selectedType)) }}</h2>
                    <p class="text-xs text-gray-400">Showing all media images uploaded in this album.</p>
                @endif
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @forelse($images as $img)
                <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md transition-shadow relative">
                    <div class="aspect-video w-full bg-gray-50 overflow-hidden cursor-pointer" onclick="openLightbox({{ $loop->index }})">
                        <img src="{{ asset($img->file_path) }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-250">
                    </div>
                    <div class="p-3 border-t border-gray-50 flex items-center justify-between gap-2 bg-white">
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-bold text-gray-800 truncate">{{ $img->caption ?: 'No caption' }}</p>
                        </div>
                        <div>
                            <form action="{{ route('gallery.destroy', $img->id) }}" method="POST" onsubmit="return confirm('Delete this image permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-gray-150 shadow-sm p-12 text-center text-gray-400 text-xs">
                    <i class="fa-solid fa-images text-3xl mb-2 block text-gray-300"></i>
                    No gallery images recorded for this event.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $images->links() }}
        </div>
    @endif
</div>

<!-- Simple Lightbox Modal -->
<div id="lightbox" class="hidden fixed inset-0 bg-gray-950/95 z-50 flex flex-col items-center justify-center p-4 backdrop-blur-sm">
    <a id="lightbox-download" href="" download class="absolute top-4 left-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Download Image">
        <i class="fa-solid fa-download"></i>
    </a>
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Close">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <button onclick="prevImage()" class="absolute left-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button onclick="nextImage()" class="absolute right-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
    <div class="flex items-center justify-center max-w-full max-h-[75vh]">
        <img id="lightbox-img" src="" class="max-h-[550px] max-w-[90vw] md:max-w-4xl object-contain rounded-xl shadow-2xl border border-white/10 bg-black/40">
    </div>
    <p id="lightbox-caption" class="text-white text-xs mt-4 font-semibold text-center max-w-[80vw] bg-black/30 px-3 py-1.5 rounded-lg"></p>
</div>

<script>
    function toggleUploadForm() {
        document.getElementById('upload-card').classList.toggle('hidden');
    }
    
    let currentImageIndex = 0;
    const galleryImages = [
        @if($images)
            @foreach($images as $img)
            { src: "{{ asset($img->file_path) }}", caption: "{{ addslashes($img->caption) }}" },
            @endforeach
        @endif
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
            const dl = document.getElementById('lightbox-download');
            if (dl) dl.href = img.src;
        }
    }

    function nextImage() { currentImageIndex++; updateLightbox(); }
    function prevImage() { currentImageIndex--; updateLightbox(); }
    function closeLightbox() { document.getElementById('lightbox').classList.add('hidden'); }

    document.addEventListener('keydown', function(e) {
        const lb = document.getElementById('lightbox');
        if (lb && !lb.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextImage();
            else if (e.key === 'ArrowLeft') prevImage();
            else if (e.key === 'Escape') closeLightbox();
        }
    });
</script>
@endsection
