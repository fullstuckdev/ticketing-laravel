<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Member;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();
        $members = Member::all();

        foreach ($members as $member) {
            Ticket::create([
                'ticket_number' => 'TICKET-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'title' => 'Sample Ticket for ' . $member->name,
                'description' => 'This is a sample ticket description.',
                'status' => 'open',
                // 'member_id' => $member->id,
                // 'user_id' => $admin->id,
            ]);
        }
    }
} 