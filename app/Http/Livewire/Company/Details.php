<?php

namespace App\Http\Livewire\Company;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Details extends Component
{

    use LivewireAlert;
    public $tenant;
    public $saveTo ='updateCompanyInformation';
    public $companyId =null;

    public function render()
    {


       $this->comapnyId =Auth::user()->currentTeam->company_id;

        $this->tenant = Company::findOrFail($this->comapnyId)->toArray();


        return view('livewire.company.details');
    }


    public function updateCompanyInformation(){

        Company::find($this->comapnyId)->update(
            $this->tenant
        );

        $this->alert('success','Details updated');


    }
}
