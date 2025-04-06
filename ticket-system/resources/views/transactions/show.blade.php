@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Transaction Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('transactions.edit', $transaction) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ticket</label>
                <a href="{{ route('tickets.show', $transaction->ticket) }}" class="text-blue-500 hover:text-blue-800">
                    #{{ $transaction->ticket->ticket_number }} - {{ $transaction->ticket->title }}
                </a>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($transaction->type === 'create') bg-green-200 text-green-800
                    @elseif($transaction->type === 'update') bg-yellow-200 text-yellow-800
                    @else bg-red-200 text-red-800 @endif">
                    {{ ucfirst($transaction->type) }}
                </span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <p class="text-gray-700 whitespace-pre-line">{{ $transaction->description }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Created By</label>
                <p class="text-gray-700">{{ $transaction->user->name }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                    <p class="text-gray-700">{{ $transaction->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Updated</label>
                    <p class="text-gray-700">{{ $transaction->updated_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 