<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['ticket', 'user'])
            ->latest()
            ->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $tickets = Ticket::where('status', '!=', 'closed')->get();
        return view('transactions.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'type' => 'required|in:create,update,close',
            'description' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['ticket', 'user']);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $tickets = Ticket::where('status', '!=', 'closed')->get();
        return view('transactions.edit', compact('transaction', 'tickets'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'type' => 'required|in:create,update,close',
            'description' => 'required|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
} 