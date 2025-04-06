@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Transaction</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ticket_id">
                    Ticket
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="ticket_id" 
                    name="ticket_id" 
                    required>
                    <option value="">Select a ticket</option>
                    @foreach($tickets as $ticket)
                        <option value="{{ $ticket->id }}" {{ old('ticket_id', $transaction->ticket_id) == $ticket->id ? 'selected' : '' }}>
                            #{{ $ticket->ticket_number }} - {{ $ticket->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                    Type
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="type" 
                    name="type" 
                    required>
                    <option value="create" {{ old('type', $transaction->type) == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ old('type', $transaction->type) == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="close" {{ old('type', $transaction->type) == 'close' ? 'selected' : '' }}>Close</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="description" 
                    name="description" 
                    rows="4" 
                    required>{{ old('description', $transaction->description) }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Transaction
                </button>
                <a href="{{ route('transactions.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection