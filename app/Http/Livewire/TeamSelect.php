<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeamSelect extends Component
{
    protected $listeners = [
        'refresh-navigation-menu'=>'$refresh',
    ];

    public function render()
    {
        return view('livewire.team-select');
    }

}
