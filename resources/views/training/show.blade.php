@extends('layouts.app')

@section('title', 'Training Program Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Training Program Details</h1>
            <p class="text-xs text-gray-500">Full parameters, stats, and photo album of the logged training session.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('training.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('training.edit', $program->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-950 transition-colors shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Program</span>
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $program->institution }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Conducted on {{ date('M d, Y', strtotime($program->date)) }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Training Program
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Institution/Office -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Institution / Venue</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $program->institution }}</span>
                </div>

                <!-- District -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">District</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $program->district }}</span>
                </div>

                <!-- Participants Count -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Participants</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-solid fa-users text-gray-400 mr-1.5"></i>
                        {{ $program->participants_count }} persons
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-gray-800 tracking-tight">Event Photo Album</h3>
            <span class="text-xs text-gray-400 font-semibold">{{ count($photos) }} Photos uploaded</span>
        </div>

        @if(count($photos) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($photos as $photo)
                    <div class="rounded-xl overflow-hidden border border-gray-150 shadow-sm aspect-video bg-gray-50 hover:opacity-95 transition-opacity cursor-pointer" onclick="openLightbox({{ $loop->index }})">
                        <img src="{{ asset($photo->file_path) }}" alt="Training photo" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400 text-xs">
                <i class="fa-solid fa-images text-2xl mb-2 block text-gray-300"></i>
                No photos uploaded for this training program.
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
        @foreach($photos as $photo)
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
