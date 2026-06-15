@extends('layouts.app')

@section('title', '5S Certification')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">5S Certification</h1>
            <p class="text-xs text-gray-500">Record, monitor, and manage 5S workspace productivity audits and certifications.</p>
        </div>
        <div>
            <a href="{{ route('five-s.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-govblue-900 hover:bg-govblue-950 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Add 5S Entry</span>
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">Program Name</th>
                            <th class="pb-3">Institution / Office</th>
                            <th class="pb-3">Date</th>
                            <th class="pb-3">Division</th>
                            <th class="pb-3">Participants</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right pr-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs text-gray-650">
                        @forelse($records as $record)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 pl-2 font-semibold text-gray-800">{{ $record->program_name }}</td>
                                <td class="py-3.5 text-gray-700">{{ $record->institution }}</td>
                                <td class="py-3.5">{{ date('Y-m-d', strtotime($record->date)) }}</td>
                                <td class="py-3.5">{{ $record->division }}</td>
                                <td class="py-3.5 font-medium text-gray-650">{{ $record->participants_count }}</td>
                                <td class="py-3.5">
                                    @if($record->status === 'Certified')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-bold">
                                            <i class="fa-solid fa-circle-check text-[9px]"></i>
                                            Certified
                                        </span>
                                    @elseif($record->status === 'Pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold">
                                            <i class="fa-solid fa-clock text-[9px]"></i>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-800 border border-rose-200 text-[10px] font-bold">
                                            <i class="fa-solid fa-circle-xmark text-[9px]"></i>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right pr-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('five-s.show', $record->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('five-s.edit', $record->id) }}" class="p-1.5 text-gray-500 hover:text-govblue-900 rounded-lg hover:bg-gray-100 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('five-s.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this 5S record?');">
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
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                                    <i class="fa-solid fa-circle-nodes text-2xl mb-2 block text-gray-300"></i>
                                    No 5S program logs recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $records->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
