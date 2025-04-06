@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Transactions</h1>
        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Transaction
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Ticket</th>
                    <th class="py-3 px-6 text-left">Type</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">User</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($transactions as $transaction)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">
                        <a href="{{ route('tickets.show', $transaction->ticket) }}" class="text-blue-500 hover:text-blue-800">
                            {{ $transaction->ticket->ticket_number }}
                        </a>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($transaction->type === 'create') bg-green-200 text-green-800
                            @elseif($transaction->type === 'update') bg-yellow-200 text-yellow-800
                            @else bg-red-200 text-red-800 @endif">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-left">{{ Str::limit($transaction->description, 50) }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->user->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->created_at->format('F j, Y g:i A') }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('transactions.show', $transaction) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('transactions.edit', $transaction) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection 