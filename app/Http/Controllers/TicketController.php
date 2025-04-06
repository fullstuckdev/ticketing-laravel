<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = Ticket::create([
            'ticket_number' => 'TKT-' . strtoupper(Str::random(8)),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'user_id' => auth()->id(),
        ]);

        // Create transaction record
        Transaction::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'transaction_type' => 'ticket_created',
            'description' => 'Ticket created',
            'metadata' => [
                'title' => $ticket->title,
                'status' => $ticket->status,
            ],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'transactions.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $oldStatus = $ticket->status;
        $ticket->update(['status' => $validated['status']]);

        // Create transaction record
        Transaction::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'transaction_type' => 'status_changed',
            'description' => 'Ticket status changed from ' . $oldStatus . ' to ' . $validated['status'],
            'metadata' => [
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
            ],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket status updated successfully.');
    }
} 