<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MobileMessagePreview extends Component
{
    protected $listeners  = ['messageUpdate'=>'updatePreview','messageSender'=>'updatePreviewSender'];

    public  $messages = [];
    public $messageCost = 0;
    public $rate = 1;
    public $sender = '';

    public function updatePreview($message){



       // $tags =  str_replace("</p>\n</p>\n", "<br/>", $message, );
        $this->messages  = $message;


        $this->creditUsage();
    }

    private function creditUsage(){

        $rate = Auth::user()->currentTeam->company->message_rate;
        $this->rate = $rate;
        $this->messageCost = $rate * count($this->messages);
    }

    public function updatePreviewSender($data){

        $this->sender = $data;
    }

    public function mount(){
        $rate = Auth::user()->currentTeam->company->message_rate;
        $this->rate = $rate;
    }



    public function render()
    {

        return view('livewire.mobile-message-preview');
    }
}
