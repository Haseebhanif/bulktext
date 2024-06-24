<?php

namespace App\Http\Livewire\Portal;

use App\Models\Company;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CompanySelect extends Component
{
    use LivewireAlert;
    public $records = 0;
    public $companyId ;

    public function render()
    {

            $data = DB::table('team_user')->select('teams.*' ,'team_user.team_id')
            ->where('team_user.user_id',Auth::id())
            ->where('isManaged',true)->join('teams', 'teams.id','=','team_id','left')
            ->get();

        $this->records =      $data->count();
        if($this->records > 0){
            $this->companyId=$data[0]->company_id;
        }


        return view('livewire.portal.company-select',[
            'managing'=>$data
        ]);
    }


    public function unmManage($id){
        $company = Company::findOrFail($id);

try{
    $teams = $company->companyTeams()->get();

    foreach ($teams as $team){
        DB::table('team_user')
            ->where( 'team_id',$team->id)
            ->where( 'user_id',Auth::user()->id)
            ->where( 'isManaged',true)
            ->delete();

        $this->alert('success','removed ');

        DB::table('users')->where('id',Auth::id())->update(['current_team_id'=>Auth::user()->allTeams()->first()->id]);



    }
    }catch (\Throwable $throwable){
        $this->alert('warning',$throwable);
    }
        $this->emit('refresh');
      return $this->redirect(route('manage.companies',session()->get('domain')));



    }
}
