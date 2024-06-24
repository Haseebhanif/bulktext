<?php

namespace App\Http\Livewire\Company;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Branding extends Component
{

    use LivewireAlert;
    use WithFileUploads;
    public $image;
    public $company;
    public $type;

    public function render()
    {
        return view('livewire.company.branding');
    }


    public function save()
    {
        $this->validate([
            'image' => 'required|image|max:2048'
        ]);

        $url =    $this->image->storeAs('branding/'.str_replace(' ','-',$this->company->company_name).'/'.$this->type.'/');

        $this->company->logo = $url;
        $this->company->save();
        $this->alert('success','Details updated');
    }
}
