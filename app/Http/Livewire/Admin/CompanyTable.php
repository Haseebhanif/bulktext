<?php

namespace App\Http\Livewire\Admin;

use App\Mail\senderAdded;
use App\Models\Company;

use App\Models\Sender;
use App\Models\StripePerTenant;
use App\Models\Team;
use App\Models\TeamCredit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyTable extends Component
{

    use LivewireAlert;
    use WithPagination;

    public $perPage = 25;
    public $orderBy = 'id';
    public $ascDesc = 'DESC';
    public $search;
    public $rowShow = 0;

    public $rate = 5;

    public $all = false;
    public  $selected =[];

    public $companyId;
    public $companyInfo = false;

    public $credits = 0;
    public $minRate = 0;

    public $modalOpen =false;
    public $selectedDeleteId;
    public $deleteName;
    public $selectedObj = null;


    public $sender = null;

    public $stripe = [
        'pk' => null,
        'sk' => null,
    ];

    protected $listeners = [
        'unmanage'=>'viewTeamRemove',
        'refresh'=>'$refresh'
      ];


    public $rules = [
      'sender'=>'required|max:11'
    ];

    public function render()
    {


        $company = Company::query();

        $company->select('users.email','users.name','companies.*')
            ->join('users', 'users.id','=','companies.creator_id','left');

        if(!$this->search){
            $company->orderBy($this->orderBy,$this->ascDesc);
        }else{
            $company->where(function ($query){
                return  $query->orWhere('company_name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('name', 'LIKE', '%'.$this->search.'%')->orWhere('email', 'LIKE', '%'.$this->search.'%');
            })
                ->orderBy($this->orderBy,$this->ascDesc);
        }
        if(Auth::user()->is_global != 1){
            $company->where('companies.tenant_id',Auth::user()->tenant_id);
        }


        $company->with(['companyTotalCredits' => function ($credits)  {
                // select the columns first, so the subquery column can be added later.
                $credits->select('*');
                return $credits->select(DB::raw('SUM(amount) AS totalCredits'))->groupBy('team_credits.id','amount','teams.company_id');
                },'companyCreator','companyLevelCredits']);

        $company->with(['companyTeams.sentMessages' => function ($teams)  {
            return $teams->count();
        }]);




        $senders = [];
        if($this->companyId){

            $senders = Sender::where('company_id',$this->companyId)->get()->toArray();

        }


        return view('livewire.admin.company-table',[
            'companies'=> $company->paginate($this->perPage),
            'senders'=> $senders
        ]);
    }

    public function activate($id){


        if($id !== $this->rowShow){
            $this->rowShow  =$id;
        }else{
            $this->rowShow  = null;
        }

    }

    public function companySelect($company){

        $this->stripe['pk'] = null;
        $this->stripe['sk'] = null;

        $this->companyId = $company;
        $this->sender = null;
        $companyObj = Company::with('tenantParent')->findOrFail($company);
        $this->selectedObj = $companyObj->toArray();

        $this->minRate = (double) number_format($companyObj->tenantParent->min_credit_rate,3);
        $this->rate = $companyObj->credit_rate;
        $this->companyInfo = true;
        $stripeInfo = StripePerTenant::where('tenant_id',$companyObj->tenant_id)->first();
        if($stripeInfo){
            $this->stripe['pk'] = $stripeInfo->stripe_token_live;
            $this->stripe['sk'] = $stripeInfo->stripe_secret_live;
        }



    }

    public function addSender(){

        $this->validate();

        Sender::create([
           'sender_name' =>$this->sender,
            'company_id'=>$this->companyId,
            'created_by'=>Auth::id()
        ]);

        //Mail::to('cmidbfbsupport@cmi.chinamobile.com')->bcc('')->bcc('andrew.yeomans@outlook.com')->
        Mail::to('cmidbfbsupport@cmi.chinamobile.com')->bcc(['andrew.yeomans@outlook.com','danielle@dbfb.co.uk'])->send(new senderAdded($this->sender));


//
//        Mail::send('emails.sender', ['sender' => $this->sender])
//            ->from('sms@keycards.io', 'DBFB NEW SENDER ID')
//            ->to('cmidbfbsupport@cmi.chinamobile.com', 'cmi dbfb support')
//            ->bcc('andrew.yeomans@outlook.com', 'Andrew Yeomans')
//            ->subject('DBFB ADD NEW SENDER ID '.$this->sender);

        $this->alert('success','Added new sender,  24 hours required before use');
        $this->sender = null;

    }

    public function removeSender($id){

        Sender::where('id',$id)->where('company_id',$this->companyId)->delete();
        $this->alert('success','Sender Removed');

    }

    public function companyCredits(){


        TeamCredit::create([
            'company_id'=>$this->companyId,
            'amount'=>$this->credits
        ]);



    }

    public function viewTeamRemove($company){


        $company = Company::findOrFail($company);
        $teams = $company->companyTeams()->get();

        foreach ($teams as $team){
            DB::table('team_user')
                ->where( 'team_id',$team->id)
                ->where( 'user_id',Auth::user()->id)
                ->where( 'isManaged',true)
                ->delete();

            $this->alert('success','removed ');
            $this->emit('refresh');
        }

    }

    public function stripeUpdate(){

        $this->validate([
            'stripe.pk'=>'required',
            'stripe.sk'=>'required'
        ]);

        $stripe = StripePerTenant::where('tenant_id',$this->selectedObj['tenant_id'])->first();

        if($stripe){

            $stripe->update([
                'stripe_token_live'=>$this->stripe['pk'],
                'stripe_secret_live'=>$this->stripe['sk'],
                 'stripe_token_test'=>$this->stripe['pk'],
                'stripe_secret_test'=>$this->stripe['sk']
            ]);
        }else{
            StripePerTenant::create([
                'tenant_id'=>$this->selectedObj['tenant_id'],
                'stripe_token_live'=>$this->stripe['pk'],
                'stripe_secret_live'=>$this->stripe['sk'],
                'stripe_token_test'=>$this->stripe['pk'],
                'stripe_secret_test'=>$this->stripe['sk']
            ]);
        }

        //remove any existing stripe customer info if changed

        User::where('tenant_id',$this->selectedObj['tenant_id'])->update([
            'stripe_id'=>null,
            'pm_type'=>null,
            'pm_last_four'=>null,
        ]);


        $this->alert('success','Stripe Keys Updated');

    }



//    public function viewTeam($company){
//
//        $company = Company::findOrFail($company);
//
//        $teams = $company->companyTeams()->get();
//
//        foreach ($teams as $team){
//            DB::table('team_user')->updateOrInsert(
//                [
//                    'team_id'=>$team->id,
//                    'user_id'=>Auth::user()->id,
//                ],
//                [
//                    'role'=>'portal',
//                    'created_at'=>(string) Carbon::now(),
//                    'updated_at'=>(string) Carbon::now(),
//                    'isManaged'=>true
//
//                ]);
//        }
//
//
//        $this->alert('success','you are now viewing selected team ');
//      $this->emit('refresh');
//        return  redirect('dashboard');
//
//    }

    public function reorder($order)
    {
        $this->orderBy = $order;
        $this->ascDesc = $this->ascDesc == 'DESC' ? 'ASC' : 'DESC';
    }

        public function rateUpdate(){

            $company =    Company::findOrFail($this->companyId);

            $this->minRate =  $company->tenantParent->min_credit_rate;

            if($this->rate >= $company->tenantParent->min_credit_rate){
                $company->credit_rate = $this->rate;
                $company->save();
                $this->alert('success','rate updated for '.$company->company_name);
            }else{
                $this->alert('warning','Your minimum credit rate is '.$company->tenantParent->min_credit_rate.' for '.$company->company_name);
            }


        }


        public function selectedDeleteId($id){

        $this->selectedDeleteId = $id;
            $this->modalOpen = true;


        }

    /**
     * Removes company
     * @return void
     */
    public function submitDelete(){


        $company = Company::findOrFail($this->selectedDeleteId);


        $this->validate([
            'deleteName' => [
                'required',
                function ($attribute, $value, $fail) use ($company) {
                    if ($value !== $company->company_name) {
                        $fail('The delete name did not match.');
                    }
                },
            ],
        ]);

        $allTeamsFromCompany = Team::select('id')->where('company_id',$company->id)->get();
        $usersEffected = User::where('current_company_id',$company->id)->get();

        foreach ($allTeamsFromCompany as $teams){
            User::where('current_company_id',$company->id)->orWhere('current_team_id',$teams->id)->update([
                'current_company_id'=>0,
                'current_team_id'=>0
            ]);
        }

        Team::where('company_id',$company->id)->delete();
        foreach ($usersEffected as $user){

            $user->update([
               'current_company_id'=>0,
               'current_team_id'=>0
            ]);
        }
        $company->delete();
        $this->modalOpen = false;
        $this->alert('success','Deleted company');
   }
}
