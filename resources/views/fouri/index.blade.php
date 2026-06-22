@extends('layouts.app')

@section('title', 'Allocations')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Allocations</h1>
            <p class="text-xs text-gray-500">Manage allocations for the initiative.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('fouri.allocations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add Allocation</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-xs font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4">
        <form action="{{ route('fouri.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search allocations by purpose, division, or program type..." class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 transition-shadow">
            </div>
            <button type="submit" class="px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Search
            </button>
            @if(isset($search) && $search !== '')
                <a href="{{ route('fouri.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Allocations Container -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Date</th>
                            <th class="pb-3">Program Type</th>
                            <th class="pb-3">Division</th>
                            <th class="pb-3">Amount (LKR)</th>
                            <th class="pb-3">Participants</th>
                            <th class="pb-3">Purpose</th>
                            <th class="pb-3">Images</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($allocations as $alloc)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-semibold text-gray-800 whitespace-nowrap">{{ $alloc->date ?? '' }}</td>
                                <td class="py-3.5">{{ $alloc->program_type ?? '' }}</td>
                                <td class="py-3.5">{{ $alloc->division_name ?? '' }}</td>
                                <td class="py-3.5 font-semibold text-gray-800">{{ number_format($alloc->amount ?? 0, 2) }}</td>
                                <td class="py-3.5">{{ $alloc->participants_count ?? 0 }}</td>
                                <td class="py-3.5 max-w-xs truncate" title="{{ $alloc->purpose ?? '' }}">{{ $alloc->purpose ?? '' }}</td>
                                <td class="py-3.5 whitespace-nowrap">
                                    @if($alloc->images && $alloc->images->count() > 0)
                                        <div class="flex items-center gap-1">
                                            @foreach($alloc->images->take(3) as $index => $img)
                                                <div class="relative w-8 h-8 rounded-lg overflow-hidden border border-gray-200 shadow-sm cursor-pointer hover:scale-105 transition-transform" 
                                                     onclick="openAllocationLightbox({{ json_encode($alloc->images->map(function($i) { return ['src' => asset('storage/' . $i->image_path), 'caption' => 'Allocation Image']; })->toArray()) }}, {{ $index }})">
                                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Allocation photo" class="w-full h-full object-cover">
                                                    @if($loop->last && $alloc->images->count() > 3)
                                                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center text-[10px] font-bold text-white">
                                                            +{{ $alloc->images->count() - 3 }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-[10px]">No images</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('fouri.allocations.show', $alloc->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fouri.allocations.edit', $alloc->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('fouri.allocations.destroy', $alloc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this allocation record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-hand-holding-dollar text-2xl mb-2 block text-gray-300"></i>
                                    No allocation records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $allocations->links() }}
            </div>
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
