<?php

namespace App\Http\Livewire\Tenancy;

use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminStats extends Component
{

    public function render()
    {


        $credits = DB::table('scheduled_messages');
        $smsSent = DB::table('scheduled_message_contacts');
        $payments = DB::table('payment_records');

        return view('livewire.tenancy.admin-stats',[
            'messages_sent'=>$smsSent->where('sent',1)->count(),
            'usedCredits'=>$credits->select('total_credits')->sum('total_credits'),
            'total_purchases'=>$payments->sum('amount')/100,
            'users'=>User::count()

        ]);
    }
}
