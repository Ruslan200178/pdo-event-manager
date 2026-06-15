@extends('layouts.app')

@section('title', 'All Notifications')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">System Notifications</h1>
            <p class="text-xs text-gray-500">Monitor all automated logs, evaluations, and administrative status updates.</p>
        </div>
    </div>

    <!-- Notification Cards List -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6 divide-y divide-gray-100">
            @forelse($notifications as $notif)
                <div class="py-4 first:pt-0 last:pb-0 flex items-start justify-between gap-4">
                    <div class="flex gap-3.5 items-start">
                        <!-- Unread Status Indicator -->
                        <div class="mt-1.5 flex-shrink-0">
                            @if(!$notif->read)
                                <span class="block w-2.5 h-2.5 rounded-full bg-govblue-600 border border-govblue-200 animate-pulse"></span>
                            @else
                                <span class="block w-2.5 h-2.5 rounded-full bg-gray-200"></span>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="text-xs font-bold text-gray-850 {{ !$notif->read ? 'text-govblue-900' : 'text-gray-700' }}">
                                {{ $notif->title }}
                            </h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $notif->message }}</p>
                            <span class="text-[10px] text-gray-400 block mt-2 font-medium">
                                <i class="fa-regular fa-clock mr-1"></i>
                                {{ $notif->created_at->format('Y-m-d h:i:s A') }} ({{ $notif->created_at->diffForHumans() }})
                            </span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if(!$notif->read)
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 bg-govblue-50 hover:bg-govblue-100 text-govblue-700 rounded-lg text-[10px] font-bold transition-colors">
                                    Mark Read
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" onsubmit="return confirm('Delete this notification permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-gray-400 text-xs">
                    <i class="fa-solid fa-bell-slash text-3xl mb-2 block text-gray-300"></i>
                    No notifications logged yet.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
