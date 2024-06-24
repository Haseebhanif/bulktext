<?php

namespace App\Http\Livewire\Tenant;

use App\Models\Tenant;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Branding extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $image;
    public $tenant;
    public $tenantId;
    public $type;

    public $color;

    public $header;
    public $body;
    public $textColor;

    public $apiAccess;

    public function mount(){


       $this->tenant = Tenant::findOrFail($this->tenantId);
       $this->apiAccess = $this->tenant->API_access ? 'true':'false';
    }

    public function render()
    {


        $this->color = $this->tenant->colour1;
        $this->textColor = $this->tenant->colour2;


        if($this->tenant->login){
            $this->header = $this->tenant->login;
        }else{
            $this->header = $this->header ?? "The SMS management revolution.";
        }

        if($this->tenant->register){
            $this->body = $this->tenant->register;
        }else{
            $this->body = $this->body ??"Millions of industries around the world use SMS to contact clients - SMS App leads the way in SMS APP contact management.";

        }

        return view('livewire.tenant.branding');
    }


    public function save()
    {

        $this->validate([
            'image' => 'required|image|max:2048'
        ]);

        $tenant = Tenant::findOrFail($this->tenantId);
        $url =    $this->image->store('branding/'.str_replace(' ','-',$tenant->tenant_name).'/'.$this->type,'public');


        $tenant->logo = 'uploads/'.$url;
        $tenant->save();
        return $this->redirect('/portal/branding');

    }

    public function saveColor(){
        $this->validate([
            'color' => 'required',
        ]);


        $this->tenant->colour1 = $this->color;
        $this->tenant->save();

    }


    public function saveText(){
        $this->validate([
            'header' => 'required',
            'body' => 'required',
        ]);

        $this->tenant->login = $this->header;
        $this->tenant->register = $this->body;
        $this->tenant->colour2 = $this->textColor;
        $this->tenant->save();

    }

    public function saveApiAccess(){
        $this->validate([
            'apiAccess' => 'required',
        ]);
        $tenant = Tenant::findOrFail($this->tenantId);
        $tenant->API_access  =  $this->apiAccess == 'true'? 1 :0;
        $tenant->save();
        $this->alert('success', 'Api setting updated.');
    }

}
