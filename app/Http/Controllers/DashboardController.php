<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Group;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\Team;
use App\Models\Tenant;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {

        //$this->middleware('check.user.status');
    }

    public function index(){

        $messagesPending = new ScheduledMessageContacts();


        $messagesDelivered = new ScheduledMessageContacts();
        $messagesFailed = new ScheduledMessageContacts();
        $messagesCredits = new ScheduledMessageContacts();
        $groups = new Group();


        $rangeStart = \Carbon\Carbon::now()->subMonth(3)->startOfMonth();
        $rangeEnd = \Carbon\Carbon::now();

        $pending =  ScheduledMessage::where('processed',false)
            ->whereBetween('send_date', [$rangeEnd->format('Y-m-d'), $rangeEnd->addMonths(12)->format('Y-m-d')])
            ->get();



        $delivered =  $messagesDelivered
            ->select('scheduled_message_contacts.*','scheduled_messages.send_date' ,'scheduled_messages.created_at')
            ->where('sent',true)
            ->where('RESULT_CODE',1)
            ->whereBetween('scheduled_messages.send_date', [$rangeStart->format('Y-m-d'), $rangeEnd->format('Y-m-d')])
            ->where('scheduled_message_contacts.team_id',Auth::user()->currentTeam->id)
            ->join('scheduled_messages','scheduled_messages.id','=','scheduled_message_contacts.scheduled_message_id')
            ->get();

        $failed =  $messagesFailed
            ->select('scheduled_message_contacts.*','scheduled_messages.send_date','scheduled_messages.created_at')
            ->where('RESULT_CODE','>',1)
            ->whereBetween('scheduled_messages.send_date', [$rangeStart->format('Y-m-d'), $rangeEnd->format('Y-m-d')])
            ->where('scheduled_message_contacts.team_id',Auth::user()->currentTeam->id)
            ->join('scheduled_messages','scheduled_messages.id','=','scheduled_message_contacts.scheduled_message_id')
            ->get();



        $groupedPending = $pending ? $this->groupDataByMonth($pending) : [];

        $groupedDelivered =  $delivered ? $this->groupDataByMonth($delivered): [];

        $groupedFailed = $failed ? $this->groupDataByMonth($failed):[];



        $contactCreated = $this->groupDataByMonthContacts(Contact::get());


        $pendingMessages = (new ColumnChartModel())->setTitle('Pending Scheduled');



            foreach ($groupedPending  as $month=>$values){
                $totalCredits =  0;

                foreach ($values  as $v){
                    $totalCredits = $v['total_credits'];
                }

                $pendingMessages->addColumn($month, $totalCredits, '#00b090');
            }



        $failedMessages = (new ColumnChartModel())->setTitle('Failed Messages');
        foreach ($groupedFailed  as $month=>$values){
            $failedMessages ->addColumn($month, $values->count(), '#DF5353');
        }

        $delivered = (new ColumnChartModel())->setTitle('Sent Messages');
        foreach ($groupedDelivered  as $month=>$values){
            $delivered->addColumn($month, $values->count(), '#00b090');
        }



        $contacts = (new ColumnChartModel())->setTitle('Contacts');
        foreach ($contactCreated  as $month=>$values){
            $contacts->addColumn($month, $values->count(), '#253369');
        }



        return view('dashboard',[

            'MessagesPending'=>$pendingMessages,
            'columnChartModel'=>$failedMessages,
            'MessagesDelivered'=>$delivered,

            'ContactsCreated'=>$contacts,

            'MessagesFailed'=>$messagesFailed->where('RESULT_CODE','>',1)->count(),
            'CreditsUsed'=>$messagesCredits->where('sent',1)->sum('credits_used'),
            'ContactGroups'=> $groups->with('contacts')->limit(10)->get()
        ]);
    }


    private function groupDataByMonth($collection){

        if($collection){
            return   $collection->groupBy(function($month,$key) {

                return Carbon::createFromFormat('Y-m-d', $month->send_date)->format('F');     //treats the name string as an array
            })->sortBy('month')->all();
        }



    }

    private function groupDataByMonthContacts($collection){

        if($collection){
            return   $collection->groupBy(function($month,$key) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $month->created_at)->format('F');     //treats the name string as an array
            })->sortBy('month')->all();
        }



    }


    public function noBusiness(Request $request){

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $host =  $request->getHost();
        $prefix = str_replace(['.','-'],'',$host);

        return view('choice',[
            'teams'=>Auth::user()->allTeams(),
            'prefix'=>$prefix,
            'domain'=>$tenant->domain,
            'isTLD'=>$tenant->istld
        ]);


    }


    public function noBusinessUpdate(Request $request){

        $this->validate($request,[
           'team'=>'required'
        ]);


       $user = Auth::user();
       $tenant = Tenant::find($user->tenant_id);
       $team = Team::findOrFail($request->team);
       $user->update([
            'current_team_id'=>$request->team,
           'current_company_id'=>$team->company_id
       ]);

        $host =  $request->getHost();
        $prefix = str_replace(['.','-'],'',$host);
        if($tenant->istld){
            return redirect()->route($prefix.'.login',['domain'=>$tenant->domain]);
        }else{
            return redirect()->route('login',['domain'=>$tenant->domain]);
        }

//      return redirect()->route($prefix.'.login',['domain'=>$tenant->domain]);

    }

}
