<?php

namespace App\Http\Livewire;


use App\Http\Traits\UsesTeamCredits;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Credits extends Component
{
    use UsesTeamCredits;

    public $credits = 0;

    protected $listeners = ['creditUpdate'=>'update'];

    public function render()
    {

        $this->credits = $this->balance(Auth::user()->currentTeam);
        return view('livewire.credits',[
            'balance'=> $this->credits['amount']
        ]);
    }

    public function update(){

        $this->credits = null;
    }
}
