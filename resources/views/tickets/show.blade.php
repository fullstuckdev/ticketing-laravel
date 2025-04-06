@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Ticket Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('tickets.edit', $ticket) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('tickets.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ticket Number</label>
                    <p class="text-gray-700">{{ $ticket->ticket_number }}</p>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($ticket->status === 'open') bg-green-200 text-green-800
                        @elseif($ticket->status === 'in_progress') bg-yellow-200 text-yellow-800
                        @else bg-red-200 text-red-800 @endif">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <p class="text-gray-700">{{ $ticket->title }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Member</label>
                    <a href="{{ route('members.show', $ticket->member) }}" class="text-blue-500 hover:text-blue-800">
                        {{ $ticket->member->name }}
                    </a>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Created By</label>
                    <p class="text-gray-700">{{ $ticket->user->name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                    <p class="text-gray-700">{{ $ticket->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Updated</label>
                    <p class="text-gray-700">{{ $ticket->updated_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Transaction History</h2>
                <a href="{{ route('transactions.create', ['ticket_id' => $ticket->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Transaction
                </a>
            </div>

            @if($ticket->transactions->count() > 0)
                <div class="space-y-4">
                    @foreach($ticket->transactions as $transaction)
                        <div class="border-l-4 
                            @if($transaction->type === 'create') border-green-500
                            @elseif($transaction->type === 'update') border-yellow-500
                            @else border-red-500 @endif pl-4 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">{{ ucfirst($transaction->type) }} by {{ $transaction->user->name }}</p>
                                    <p class="text-gray-600">{{ $transaction->description }}</p>
                                </div>
                                <span class="text-sm text-gray-500">{{ $transaction->created_at->format('F j, Y g:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No transactions recorded for this ticket.</p>
            @endif
        </div>
    </div>
</div>
@endsection