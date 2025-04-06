@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Member Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('members.edit', $member) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('members.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <p class="text-gray-700">{{ $member->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <p class="text-gray-700">{{ $member->email }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <p class="text-gray-700">{{ $member->phone ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <p class="text-gray-700">{{ $member->address ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                <p class="text-gray-700">{{ $member->created_at->format('F j, Y g:i A') }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Last Updated</label>
                <p class="text-gray-700">{{ $member->updated_at->format('F j, Y g:i A') }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Associated Tickets</h2>
            @if($member->tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Ticket Number</th>
                                <th class="py-3 px-6 text-left">Title</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-left">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($member->tickets as $ticket)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500 hover:text-blue-800">
                                        {{ $ticket->ticket_number }}
                                    </a>
                                </td>
                                <td class="py-3 px-6 text-left">{{ $ticket->title }}</td>
                                <td class="py-3 px-6 text-left">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($ticket->status === 'open') bg-green-200 text-green-800
                                        @elseif($ticket->status === 'in_progress') bg-yellow-200 text-yellow-800
                                        @else bg-red-200 text-red-800 @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left">{{ $ticket->created_at->format('F j, Y g:i A') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">No tickets associated with this member.</p>
            @endif
        </div>
    </div>
</div>
@endsection 