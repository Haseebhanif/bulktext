<?php

namespace App\Http\Livewire\Tenancy;

use App\Exports\CreditPaymentExport;
use App\Exports\SentSMSExport;
use App\Http\Traits\ChinaMobileAPI;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Excel;

class AdminDashboard extends Component
{
    use WithPagination;
    use LivewireAlert;
    use ChinaMobileAPI;

    protected $listeners = ['rangeSet'=>'dateRange'];

    public $modal = false;
    public $modalUser = false;
    public $reports = false;

    public $perPage = 10;
    public $orderBy = 'company_name';
    public $ascDesc = 'DESC';
    public $search;


    public $tenant = [];
    public $tenantUsers = [];



    public $selectedDownload;
    public $from;
    public $to;



    protected $rules = [
        'tenant.domain' => 'required|min:2|unique:tenants,domain',
        'tenant.company_name' => 'required|min:2|string',
        'tenant.min_credit_rate' => 'required',
        'tenant.tenant_name' => 'required|string|min:2',
    ];



    public function render()
    {
     //   dd($this->deliveryReports());

       $tenant = Tenant::query();
       $tenant->orderBy($this->orderBy, $this->ascDesc);
        if ($this->search) {
            $tenant->where(function ($item){
                $item->orWhere('tenant_name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('company_name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('domain', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('min_credit_rate', 'LIKE', '%'.$this->search.'%');
            });

        }

        return view('livewire.tenancy.admin-dashboard',[
            'tenants'=>$tenant->paginate($this->perPage)
        ]);
    }

    public function submit(){

        if(array_key_exists('id', $this->tenant)){
         return   $this->save();
        }
        $this->validate();



        Tenant::create($this->tenant);
        $this->tenant = null;

        $this->alert('success','Tenant added ');
        $this->discard();
    }

    public function save(){

        $this->tenant['domain'] = mb_strtolower($this->tenant['domain']);
       $tenant = Tenant::updateOrcreate(
            [
                'id'=>$this->tenant['id']
            ],
           [
                'company_name'=>$this->tenant['company_name'],
                'domain'=>$this->tenant['domain'],
                'min_credit_rate'=>$this->tenant['min_credit_rate'],
                'status'=>$this->tenant['status'],
                'tenant_name'=>$this->tenant['tenant_name']
           ]
        );


        if(!$tenant->stripeConnection()->exists()){
            $tenant->stripeConnection()->create([
                'tenant_id'=>$tenant->id,
                'stripe_key'=>env('STRIPE_KEY'),
                'stripe_secret'=>env('STRIPE_SECRET'),
                'stripe_token_test'=>env('STRIPE_KEY'),
                'stripe_secret_test'=>env('STRIPE_SECRET'),
            ]);
        }

        $this->tenant = null;

        $this->alert('success','Tenant updated ');
        $this->discard();
    }

    public function submitUsers($id){

       $array = explode('-',$id);

      $user = User::findOrFail($this->tenantUsers[$array[0]]['id']);

      if($array[1] == 'portal'){
          $user->is_portal = !$this->tenantUsers[$array[0]]['is_portal'];
      }
        if($array[1] == 'global'){
            $user->is_global = !$this->tenantUsers[$array[0]]['is_global'];
        }
        $user->save();

        $this->alert('success','Changes Saved');
    }


    public function order($value){

        $this->orderBy = $value;
        if($this->ascDesc == 'DESC'){
            $this->ascDesc = 'ASC';
        }else{
            $this->ascDesc = 'DESC';
        }

    }

    public function edit($id){

        $tent =Tenant::findOrFail($id);
        $this->tenant =  [
            'id' => $tent->id,
            'domain' => strtolower($tent->domain),
            'company_name' => $tent->company_name,
            'min_credit_rate' => $tent->min_credit_rate,
            'tenant_name' => $tent->tenant_name,
            'status' => $tent->status,
        ];
        $this->modal = true;
    }


    public function users($id){
        $tent =Tenant::findOrFail($id);
        $this->tenantUsers  = User::where('tenant_id',$tent->id)->get()->toArray();
        $this->modalUser = true;
    }
    public function discard(){

        $this->modal = false;
        $this->modalUser = false;
        $this->tenantUsers = [];
    }


//    EXPORT FUNCTION

    public function dateRange($data){


        $this->from = $data['from'];
        $this->to = $data['till'];
    }

    public function exportDate($data){

        switch ($data){
            case 'SMS_SENT':
                return Excel::download(new SentSMSExport($this->from, $this->to), $data.'.xlsx');
            case 'CREDITS':
                return Excel::download(new CreditPaymentExport($this->from, $this->to), $data.'.xlsx');
        }



    }

    public function setDownload($name){
        $this->selectedDownload = $name;
    }

    public function newTenant(){

        $this->tenant = [];
        $this->modal= true;
    }





}
