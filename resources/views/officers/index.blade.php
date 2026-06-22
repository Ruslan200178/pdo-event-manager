@extends('layouts.app')

@section('title', 'Productivity Development Officers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Productivity Development Officers</h1>
            <p class="text-xs text-gray-500">View and manage registered Productivity Development Officers (PDO) profiles and DS division assignments.</p>
        </div>
        <div>
            <a href="{{ route('officers.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-user-plus"></i>
                <span>Add Officer Profile</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm p-4">
        <form action="{{ route('officers.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name, division, or NIC..." class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-xl focus:outline-none focus:ring-1 focus:ring-govblue-500 transition-shadow">
            </div>
            <button type="submit" class="px-4 py-2 bg-govblue-900 text-white hover:bg-govblue-950 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Search
            </button>
            @if(isset($search) && $search !== '')
                <a href="{{ route('officers.index') }}" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-750 rounded-xl text-xs font-semibold shadow-sm transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Officer Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($officers as $officer)
            <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-md transition-shadow">
                <!-- Profile Image & Header -->
                <div class="p-6 text-center flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-govblue-50 bg-gray-100 flex items-center justify-center mb-4">
                        @if($officer->photo_path)
                            <img src="{{ asset($officer->photo_path) }}" alt="{{ $officer->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user-tie text-gray-400 text-3xl"></i>
                        @endif
                    </div>
                    
                    <h3 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $officer->name }}</h3>
                    <span class="text-[10px] font-bold text-govblue-600 bg-govblue-50 px-2.5 py-0.5 rounded-full mt-1.5 border border-govblue-100">{{ $officer->division_name }}</span>
                    
                    <div class="mt-4 space-y-1 w-full text-left text-xs border-t border-gray-50 pt-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">NIC No:</span>
                            <span class="font-medium text-gray-700">{{ $officer->nic_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Appointment:</span>
                            <span class="font-medium text-gray-700">{{ $officer->appointment_date }}</span>
                        </div>
                        @if($officer->divisional_secretariat)
                            <div class="flex justify-between">
                                <span class="text-gray-400">DS Office:</span>
                                <span class="font-medium text-gray-700">{{ $officer->divisional_secretariat }}</span>
                            </div>
                        @endif
                        @if($officer->district_rank)
                            <div class="flex justify-between">
                                <span class="text-gray-400">District Rank:</span>
                                <span class="font-medium text-gray-700">{{ $officer->district_rank }}</span>
                            </div>
                        @endif
                        @if(!is_null($officer->progress_percentage))
                            <div class="mt-2 pt-2 border-t border-gray-50/50">
                                <div class="flex justify-between text-[10px] text-gray-400 mb-1">
                                    <span>Progress:</span>
                                    <span class="font-bold text-gray-700">{{ $officer->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-govblue-600 h-1.5 rounded-full" style="width: {{ $officer->progress_percentage }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer buttons -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-100 flex items-center justify-between gap-2">
                    <a href="{{ route('officers.show', $officer->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white border border-gray-250 text-[10px] font-bold text-gray-700 rounded-lg hover:bg-gray-55 shadow-sm transition-colors">
                        <i class="fa-solid fa-eye"></i>
                        <span>View Profile</span>
                    </a>
                    <a href="{{ route('officers.edit', $officer->id) }}" class="p-1.5 bg-white border border-gray-250 text-gray-500 rounded-lg hover:text-govblue-900 hover:bg-gray-55 shadow-sm transition-colors">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </a>
                    <form action="{{ route('officers.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Delete this officer profile?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 bg-white border border-gray-250 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 shadow-sm transition-colors">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-150 shadow-sm p-12 text-center text-gray-400 text-xs">
                <i class="fa-solid fa-user-slash text-3xl mb-2 block text-gray-300"></i>
                No officer profiles logged yet.
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $officers->links() }}
    </div>
</div>
@endsection
