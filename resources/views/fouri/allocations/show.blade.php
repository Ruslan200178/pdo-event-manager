@extends('layouts.app')

@section('title', 'Allocation Details')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Allocation Details</h1>
            <p class="text-xs text-gray-500 mt-1">View detailed information of this allocation record.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('fouri.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to List</span>
            </a>
            <a href="{{ route('fouri.allocations.report', $allocation->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Report View</span>
            </a>
            <a href="{{ route('fouri.allocations.edit', $allocation->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 text-white rounded-xl text-xs font-semibold hover:bg-govblue-955 shadow-sm transition-colors">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Entry</span>
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Allocation</h2>
                    <p class="text-xs text-gray-400 mt-1">Created {{ $allocation->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-govblue-50 text-govblue-700 text-xs font-bold rounded-full border border-govblue-100">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <span>Allocation Entry</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">
                        <i class="fa-regular fa-calendar text-gray-450 mr-1.5"></i>
                        {{ date('F d, Y', strtotime($allocation->date)) }}
                    </span>
                </div>

                <!-- Division Name -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">DS Division</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $allocation->division_name }}</span>
                </div>

                <!-- Amount -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</span>
                    <span class="text-sm font-bold text-govblue-900 block mt-1">LKR {{ number_format($allocation->amount, 2) }}</span>
                </div>

                <!-- Program Type -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Program Type</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $allocation->program_type }}</span>
                </div>

                <!-- Participants Count -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Participants Count</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-1">{{ $allocation->participants_count }}</span>
                </div>
            </div>

            <!-- Purpose -->
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Purpose</span>
                <div class="text-sm text-gray-650 mt-2 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-line">
                    {{ $allocation->purpose }}
                </div>
            </div>

            <!-- Image Gallery -->
            @if($allocation->images && $allocation->images->count() > 0)
                <div class="border-t border-gray-100 pt-6">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Attached Photos ({{ $allocation->images->count() }})</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($allocation->images as $index => $img)
                            <div class="rounded-xl overflow-hidden border border-gray-150 shadow-sm aspect-video bg-gray-50 hover:opacity-95 transition-opacity cursor-pointer" 
                                 onclick="openAllocationLightbox({{ json_encode($allocation->images->map(function($i) { return ['src' => asset('storage/' . $i->image_path), 'caption' => 'Allocation Image']; })->toArray()) }}, {{ $index }})">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Allocation photo" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Simple Lightbox Modal -->
<div id="allocation-lightbox" class="hidden fixed inset-0 bg-black/95 z-50 flex flex-col items-center justify-center p-4">
    <!-- Download button (Top-Left) -->
    <a id="lightbox-download" href="" download class="absolute top-4 left-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Download Image">
        <i class="fa-solid fa-download"></i>
    </a>

    <!-- Close button (Top-Right) -->
    <button onclick="closeAllocationLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-55 flex items-center justify-center p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors" title="Close">
        <i class="fa-solid fa-xmark"></i>
    </button>
    
    <!-- Prev button -->
    <button id="lightbox-prev" onclick="prevAllocationImage()" class="absolute left-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    
    <!-- Next button -->
    <button id="lightbox-next" onclick="nextAllocationImage()" class="absolute right-4 text-white hover:text-gray-300 text-3xl z-50 p-2 bg-black/30 hover:bg-black/55 rounded-full transition-colors">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <img id="lightbox-img" src="" class="max-h-[75vh] max-w-[85vw] object-contain rounded shadow-2xl">
    <p id="lightbox-caption" class="text-white text-xs mt-4 font-semibold text-center max-w-[80vw] bg-black/40 px-3 py-1.5 rounded-lg"></p>
</div>

<script>
    let currentImageIndex = 0;
    let lightboxImages = [];

    function openAllocationLightbox(images, index) {
        lightboxImages = images;
        currentImageIndex = index;
        updateAllocationLightbox();
        document.getElementById('allocation-lightbox').classList.remove('hidden');
    }

    function updateAllocationLightbox() {
        if (lightboxImages.length === 0) return;
        if (currentImageIndex < 0) currentImageIndex = lightboxImages.length - 1;
        if (currentImageIndex >= lightboxImages.length) currentImageIndex = 0;
        
        const img = lightboxImages[currentImageIndex];
        if (img) {
            document.getElementById('lightbox-img').src = img.src;
            document.getElementById('lightbox-caption').textContent = img.caption || 'Allocation Image';
            const downloadBtn = document.getElementById('lightbox-download');
            if (downloadBtn) {
                downloadBtn.href = img.src;
            }
        }

        // Hide navigation arrows if there is only 1 image
        const prevBtn = document.getElementById('lightbox-prev');
        const nextBtn = document.getElementById('lightbox-next');
        if (lightboxImages.length <= 1) {
            if (prevBtn) prevBtn.classList.add('hidden');
            if (nextBtn) nextBtn.classList.add('hidden');
        } else {
            if (prevBtn) prevBtn.classList.remove('hidden');
            if (nextBtn) nextBtn.classList.remove('hidden');
        }
    }

    function nextAllocationImage() {
        currentImageIndex++;
        updateAllocationLightbox();
    }

    function prevAllocationImage() {
        currentImageIndex--;
        updateAllocationLightbox();
    }

    function closeAllocationLightbox() {
        document.getElementById('allocation-lightbox').classList.add('hidden');
    }

    // Add arrow key listener
    document.addEventListener('keydown', function(event) {
        const lightbox = document.getElementById('allocation-lightbox');
        if (lightbox && !lightbox.classList.contains('hidden')) {
            if (event.key === 'ArrowRight') {
                nextAllocationImage();
            } else if (event.key === 'ArrowLeft') {
                prevAllocationImage();
            } else if (event.key === 'Escape') {
                closeAllocationLightbox();
            }
        }
    });
</script>
@endsection
