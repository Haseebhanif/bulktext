<?php

namespace App\Http\Livewire\Optout;

use Livewire\Component;
use AshAllenDesign\ShortURL\Facades\ShortURL;


class Optout extends Component
{



    public function render()
    {
        $shortURLObject = ShortURL::destinationUrl('https://destination.com')->make();
        dd($shortURLObject);
        return view('livewire.optout.optout');
    }


    public function generateOptOuts($data){

    }
}
