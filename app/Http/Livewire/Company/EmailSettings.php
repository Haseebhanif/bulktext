<?php

namespace App\Http\Livewire\Company;

use App\Models\EmailService;
use App\Models\Tenant;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EmailSettings extends Component
{
    use LivewireAlert;

    public $saveTo  ='save';

    public $tenantId;

    public $email;
    public $name;
    public $username;
    public $password;
    public $port;
    public $encryption = 'SSL';
    public $smtp;


    protected $rules = [

        'smtp'=>'required',
        'name'=>'required',
        'email'=>'required',
        'username'=>'required',
        'password'=>'required',
        'port'=>'required',
        'encryption'=>'required'
    ];


    public function mount(){
      $session =   Session::get('domain');
      $tenant =  Tenant::where('domain',$session)->firstOrFail();
      $this->tenantId = $tenant->id;

        $settings =  EmailService::where('tenant_id',$this->tenantId)->first();

        if($settings){
            $this->name = $settings->name;
            $this->smtp = $settings->smtp;
            $this->email = $settings->email;
            $this->username = $settings->username;
            $this->port = $settings->port;
            $this->encryption = $settings->encryption;
            config(
                [
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.host' => $this->smtp,
                    'mail.mailers.smtp.port' => $this->port,
                    'mail.mailers.smtp.encryption' =>$settings->encryption,
                    'mail.mailers.smtp.username' => $this->username,
                    //pw is encrypted during save process
                    'mail.mailers.smtp.password' => $settings->password,
                    'mail.from.address'=>$this->email,
                    'mail.from.name'=> $this->name,
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.company.email-settings');
    }



    public function save(){

        $this->validate();
        EmailService::updateOrCreate([
            'tenant_id'=>$this->tenantId
        ],[
            'name'=>$this->name,
            'smtp'=>$this->smtp,
            'email'=>$this->email,
            'username'=>$this->username,
            'password'=>encrypt($this->password),
            'port'=>$this->port,
            'encryption'=>$this->encryption,

        ]);
        $this->alert('success','SMTP Details Updated');
    }
}
