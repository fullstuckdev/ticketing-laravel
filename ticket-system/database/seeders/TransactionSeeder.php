<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            Transaction::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'type' => 'create',
                'description' => 'Ticket created by ' . $admin->name,
            ]);
        }
    }
} 