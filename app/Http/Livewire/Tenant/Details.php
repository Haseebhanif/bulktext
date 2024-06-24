<?php

namespace App\Http\Livewire\Tenant;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Details extends Component
{
    use LivewireAlert;
    public $tenant;
    public $saveTo ='updateTenantInformation';


    public function render()
    {

       // dd(Auth::user()->company);

        $this->tenant = Tenant::find(Auth::user()->tenant_id)->toArray();
        return view('livewire.company.details');
    }


    public function updateTenantInformation(){


      $this->tenant =  Tenant::find(Auth::user()->tenant_id)->update(
            $this->tenant
        );


        $this->alert('success','Details updated');

    }
}
