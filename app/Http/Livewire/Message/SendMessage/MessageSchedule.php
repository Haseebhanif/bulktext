<?php

namespace App\Http\Livewire\Message\SendMessage;

use App\Models\MessageTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageSchedule extends Component
{
    public $date;
    public $selected;
    public $templates = [];
    public $companyTemplates = [];



    public function render()
    {
        return view('livewire.message.send-message.message-schedule');
    }

}
