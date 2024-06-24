<?php

namespace App\Http\Livewire\Message\SendMessage;


use App\Events\ScheduledContactsEvent;
use App\Http\Traits\UserDefinedVars;
use App\Http\Traits\UsesTeamCredits;
use App\Jobs\ContactsToSchedule;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\CustomContactInfo;
use App\Models\Group;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\Sender;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MessageSteps extends Component
{
    use UserDefinedVars;
    use WithPagination;
    use LivewireAlert;
    use UsesTeamCredits;

    protected $listeners = [
        'templateSelected'=> 'updateTextarea',
        'scheduleGroupClick'=>'selectedContactGroup',
        'confirmedDelete'=>'confirmCampaignRemoval',
        'dateChange'=>'dateSelectUpdate',
        'characters'=>'characterCount'

    ];

    public $completeMessageInfo = [
        'id'=>null,
        'sender'=>null,
        'date'=>null,
        'hour'=>null,
        'min'=>null,
        'sendnow'=>false,
        'name'=>null,
        'message'=>null,
        'contacts'=>[],
        'vars'=> [],
        'totalCredits'=>0,
        'editAllow'=>true,
        'optOut'=>true,
    ];

    public $currentStep = 0;
    public $percentage = 0;

    public $senders =[
            [
                'id'=>'TxtMgt', 'sender'=>'TxtMgt',
                'id'=>'Dominos', 'sender'=>'Dominos'
            ]
    ];
    public $groups =[];
    public $hours = [];
    public $mins = [];

    public $selectedGroup;

   public $groupSelectCredits = 0;

//    Message

    public $length=0;
    public $maxLength = 160;
    public $message;
    public $messageHTML;
    public $optOutmessage = 'OptOut? tap [LINK]';
    public $variables = [];
    public $contactCustomVarsList = [];

    public $contactVariables = [
        ['info'=>'Contacts number', 'placeholder'=> '[number]','addOptOutTxt']
    ];
    public $messageAfterVars;

   // public $contacts = [];
    public $contactList = [];
    public $totalCredits = 0;
    public $total = 0;

    public $contactFeedback =[];
    public $optoutCount = 0;


    public $scheduled = null;

    /**
     * used when reopening campaign to alert
     * user the status is draft & credits re allocated
     * @var bool
     */
    public $reopen = false;

    public $sendContacts =[];


    public function mount(){
        $this->groups = Group::with('activeContacts')->withCount('activeContacts')->get();
        $this->contactVariables =     $this->userVars();
     if(!$this->completeMessageInfo['id']){
         $this->completeMessageInfo['date'] = Carbon::now()->format('d-m-Y');
         $this->completeMessageInfo['hour'] = Carbon::now()->addHour(2)->format('H');
         $this->completeMessageInfo['min'] = 30;



     }else{

         $this->isEditiable();
     }
     if($this->reopen){
         $this->alert('warning','status changed to draft');
     }

        $this->characterCount();
        $this->hours = Lang::get('times')['hours'];
        $this->mins = Lang::get('times')['mins'];

        if($this->completeMessageInfo['optOut'] ==true){
            $this->maxLength= $this->maxLength -30;

        }else{
            $this->maxLength= $this->maxLength + 30;
        }


        $this->senders =   Sender::where('company_id',Auth::user()->currentTeam->company_id)->whereDate('created_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get()->map(function ($item){

            return [

               'sender_id'=>$item->id,
              'id'=>$item->sender_name,
              'sender'=>$item->sender_name
            ];

        });




    }

    public function render()
    {



        $this->groups = Group::whereHas('activeContacts',function ($contact){
            return $contact->where('active',1);
        })->withCount('contacts')->get();
        $this->characterCount();



        if($this->completeMessageInfo['sender']){
            foreach ($this->senders as $key=>$value){
                if($value['id'] ==$this->completeMessageInfo['sender']){
                    $this->emit('messageSender',  $this->senders[$key]['sender']);
                }
            }
        }

        return view('livewire.message.send-message.message-steps',[
            'message'=>$this->message,
            'count'=>$this->length,
            'contacts'=> $this->refactorContactsOnMessageUpdate()
        ]);
    }

    public function isEditiable(){


        $currentSendDate =  Carbon::createFromFormat('d-m-Y H:i',$this->completeMessageInfo['date'].' '.$this->completeMessageInfo['hour'].':'.$this->completeMessageInfo['min']);

        //restrict schedule editing within 5 mins of send time.
        if(Carbon::now()->subMinute(5)  >= $currentSendDate){
         return   $this->completeMessageInfo['editAllow'] = false;
        }
//        //restrict schedule editing within 5 mins of send time.
//        if($currentSendDate <= Carbon::now()->subMinute(5)){
//            return   $this->completeMessageInfo['allowEdit'] = false;
//        }




    }

    public function groupSelected(){

      // $this->emit('scheduleGroupClick',$this->selectedGroup);


        if($this->selectedGroup== 0){
            $this->contactList = [];
            $this->contactFeedback = [];
            $this->selectedContactGroup([]);
            $this->total = 0;
            return $this->alert('warning','A contact group is required');
        }

       $contactGroup = new ContactGroup();

        if($contactGroup->where('group_id',$this->selectedGroup)->count() > 0){
            $contacts =   ContactGroup::where('group_id',$this->selectedGroup)->get('contact_id')->toArray();
            $this->selectedContactGroup(Arr::flatten($contacts));


       $customs =  CustomContactInfo::whereIn('contactable_id',$this->contactList)->get()->map(function ($item){
               return [
                   'info'=>"Contact ref:".str_replace('custom_',' ',$item->custom_name)."",
                   'placeholder'=> '['.$item->custom_name.']'
               ];
         })->toArray();
            $this->contactVariables =  array_map("unserialize", array_unique(array_map("serialize", $customs)));

            array_push($this->contactVariables,['info'=>'Contacts number', 'placeholder'=> '[number]']);


        }else{
            $this->selectedContactGroup([]);
        }









    }

    public function characterCount(){


        $brAdded=  nl2br($this->message);
//        $this->toSMSformat( $brAdded);
//        $replaced =  str_replace('<br />', '</p>',   $brAdded);
//          $string = trim(preg_replace("</p>\n</p>\n", '<br/>', $replaced));
/*        preg_replace("/<p[^>]*?>/", "", $replaced);*/



        $this->messageHTML =    $this->completeMessageInfo['optOut'] == true ?    $this->toSMSformat($brAdded.' '.$this->optOutmessage) : $this->toSMSformat(str_replace($this->optOutmessage, '', $brAdded));

        $this->messageAfterVars = $this->message;


        if($this->completeMessageInfo['optOut'] && !str_contains($this->message,$this->optOutmessage)){
            $this->messageAfterVars = $this->message .' '.$this->optOutmessage;

        }elseif (!$this->completeMessageInfo['optOut'] && str_contains($this->message, $this->optOutmessage)){

            $this->messageAfterVars =  str_replace($this->optOutmessage, '', $this->message);
        }


        foreach ($this->variables as $value){
            if($value['value'] && $value['placeholder']){
                $this->messageAfterVars =   str_replace($value['placeholder'], $value['value'],  $this->messageAfterVars);
            }
        }

        $this->length = strlen($this->toSMSformat(  $this->messageAfterVars));


        if($this->length > $this->maxLength) {
            $this->messagesToSave = str_split($this->toSMSformat( $this->messageAfterVars), $this->maxLength);
        }else{
            $this->messagesToSave =[ $this->toSMSformat( $this->messageAfterVars)];
        }


        $this->length > $this->maxLength ?  $this->emit('messageUpdate',str_split($this->messageHTML, $this->maxLength)):  $this->emit('messageUpdate',[$this->messageHTML]);
    }


    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );


        return \Soundasleep\Html2Text::convert($message, $options);
    }


    public function refactorContactsOnMessageUpdate($saveCamp = false){

        $this->totalCredits = 0;
        $this->groupSelectCredits = 0;

        if(count($this->completeMessageInfo['contacts']) == 0){
            $this->completeMessageInfo['contacts'] = [];
            return [];
        }





        $test = Contact::select('contacts.id','contacts.active','contacts.number','contacts.country_code','contacts.team_id','custom_contact_infos.custom_name','custom_contact_infos.custom_value')

            ->whereIn('contacts.id',$this->completeMessageInfo['contacts'])
            ->join('custom_contact_infos','custom_contact_infos.contactable_id','=','contacts.id','left')
            ->where('active',1)
            ->groupBy('contacts.id','contacts.active','contacts.number','contacts.country_code','contacts.team_id','custom_contact_infos.custom_name','custom_contact_infos.custom_value')
            ->distinct('contacts.id')
            ->get();



        $mapping = $test->map(function($item){
            $contactMessage = $this->message;
            //template
            foreach ($this->variables as $value){

                if($value['value'] && $value['placeholder']){
                    $contactMessage =   str_replace($value['placeholder'], $value['value'],  $contactMessage);
                }

            }
            //contact
            foreach ($this->contactVariables as $value){
                if($value['placeholder']){
                    $contactMessage=   str_replace($value['placeholder'], $this->contactVarReplace($value['placeholder'],$item),  $contactMessage);
                }

            }

            $msgLength = strlen($this->toSMSformat(  $contactMessage));

            $credits = 0;

            if($msgLength > $this->maxLength) {
                $credits = str_split($this->toSMSformat( $this->messageAfterVars), $this->maxLength);
            }else{
                $credits  =[ $this->toSMSformat( $this->messageAfterVars)];
            }

            if($this->message != null ){
                $this->totalCredits += ceil(($msgLength/$this->maxLength));
            }


            $item['preview'] =  $contactMessage;
            $item['credits'] = ceil(($msgLength/$this->maxLength));
            $item['characters']= $msgLength;

            return $item;
        });





        $this->messageBreakdown($mapping);

        $this->optoutCount = count($this->completeMessageInfo['contacts']) - count($mapping);
        $this->completeMessageInfo['totalCredits']  = $mapping->sum('credits');
        if($saveCamp){
            return collect($mapping)->sortByDesc('characters');
        }

        $contacts =  collect($mapping)->sortByDesc('characters')->paginate(25);


        $this->total =$contacts->total();


        return $contacts;

    }


    public function messageBreakdown($contacts){



          $contactFeedback =  $contacts->groupBy(function($person,$key) {
                    return $person->credits;     //treats the name string as an array
                })->sortBy(function($item,$key){      //sorts A-Z at the top level
                        return $key;
                    })->all();


                    $this->contactFeedback = $contactFeedback;


    }

    public function selectedContactGroup($contacts){


        $this->completeMessageInfo['contacts'] = $contacts;
        $this->contactList = $contacts;

    }



//    MESSAGE VARS

    public function addVariable(){
        $new = [
            'placeholder'=>'[VariableName]',
            'value'=>null,
        ];
        array_push($this->variables ,$new);
    }

    public function updateTextarea($template){


        $this->message =$template['text'];
        $this->variables =$template['vars'];

        $this->alert('success', 'Template added to message window');

    }

    private function contactVarReplace($value,$contact){


        if (str_contains($value,'custom_')) {
            $string = str_replace(array('[',']'),'',$value);


           if($contact->custom_name && mb_strtolower($contact->custom_name) == mb_strtolower($string)){
               return $contact->custom_value;
           }

        }

        switch($value){
            case '[company_name]':
                return Team::find($contact->team_id)->company->company_name;
            case '[number]':
                return $contact->number;
            default:
                $string = str_replace(array('[',']'),'',$value);
                $data  =  CustomContactInfo::where('contactable_id',$contact->id)->where('custom_name',$string)->first();
              if($data){
                  return $data->custom_value;
              }


        }



    }

    //MESSAGE SAVE

    public function sendMessage(Request $request){

//        $this->validate([
//           'messagesToSave.message'=>'array:0',
//           'completeMessageInfo.contacts'=>'array:0'
//        ]);

        if($this->completeMessageInfo['sender'] == 0){
            return $this->alert('warning','A sender is required');
        }

        if(count($this->contactList) == 0){
            return $this->alert('warning','A contact group is required');
        }




           if($this->totalCredits <= Auth::user()->currentTeam->credits->amount) {
               $this->deductCredits($this->totalCredits);
           }else{
               return
                   $this->alert('warning','Insufficient credits to complete this schedule');
           }

          $sendTo = ContactGroup::select('contacts.*','group_contacts.group_id','group_contacts.contact_id')->where('group_contacts.group_id',$this->selectedGroup)->join('contacts','contacts.id','=','group_contacts.contact_id','left')
               ->where('contacts.active',1)
               ->count();


           if(!$this->completeMessageInfo['id']){
               tap(ScheduledMessage::create(
                   [
                       'message'=>$this->messageHTML,
                       'variables'=>json_encode([
                           'template'=>  $this->variables,
                           'global'=>   $this->contactVariables
                       ]),
                       'optout'=>$this->completeMessageInfo['optOut'],
                       'sender_id'=>$this->completeMessageInfo['sender'],
                       'group_id'=>$this->selectedGroup,
                       'name'=> $this->completeMessageInfo['name'],
                       'team_id'=>Auth::user()->currentTeam->id,
                       'company_id'=>Auth::user()->currentTeam->company->id,
                       'user_id'=>Auth::user()->id,
                       'total_credits'=> $this->totalCredits,
                       'total_contacts'=> $sendTo,
                       'send_date'=> Carbon::createFromFormat('d-m-Y', $this->completeMessageInfo['date'])->format('Y-m-d'),
                       'send_time'=>$this->completeMessageInfo['hour'].':'.$this->completeMessageInfo['min'],
                       'status'=>"importing"
                   ]),
                   function (ScheduledMessage $scheduledMessage){

                       $this->sendContacts = $this->refactorContactsOnMessageUpdate(true);



                       if($this->totalCredits > Auth::user()->currentTeam->credits->amount){
                           $scheduledMessage->status = 'draft';
                           $scheduledMessage->update();
                       }
                       $this->scheduled = $scheduledMessage;



                   });
           }else{
               tap(ScheduledMessage::updateOrCreate(
                   [
                       'id'=>$this->completeMessageInfo['id']
                   ],
                   [
                       'message'=>$this->message,
                       'variables'=>json_encode([
                           'template'=>  $this->variables,
                           'global'=>   $this->contactVariables
                       ]),
                       'sender_id'=>$this->completeMessageInfo['sender'],
                       'group_id'=>$this->selectedGroup,
                       'name'=> $this->completeMessageInfo['name'],
                       'team_id'=>Auth::user()->currentTeam->id,
                       'company_id'=>Auth::user()->currentTeam->company->id,
                       'user_id'=>Auth::user()->id,
                       'total_credits'=> $this->totalCredits,
                       'total_contacts'=> $sendTo,
                       'send_date'=> Carbon::createFromFormat('d-m-Y', $this->completeMessageInfo['date'])->format('Y-m-d'),
                       'send_time'=>$this->completeMessageInfo['hour'].':'.$this->completeMessageInfo['min'],
                       'status'=>"pending"
                   ]),
                   function (ScheduledMessage $scheduledMessage){

                       $this->sendContacts = $this->refactorContactsOnMessageUpdate(true);



                       if($this->totalCredits > Auth::user()->currentTeam->credits->amount){
                           $scheduledMessage->status = 'draft';
                           $scheduledMessage->update();
                       }
                       $this->scheduled = $scheduledMessage;


                   });
           }




            $this->emit('creditUpdate');
            if($this->totalCredits > Auth::user()->currentTeam->credits->amount){
                session()->flash('message', 'Campaign  Draft saved successfully! Please Add more credits to send.');
            }else{
                session()->flash('message', 'Campaign successfully added.');
            }

            $company = Auth::user()->currentTeam->company->id;
            $rate = Auth::user()->currentTeam->company->message_rate;

               if(!$this->completeMessageInfo['id']){
                   config(['short-url.default_url'=>\url('/')]);
                   dispatch(new ContactsToSchedule($this->scheduled->id,$this->scheduled->group_id,json_encode($this->sendContacts),$company,$rate,\url('/')));
               }

            // event(new ScheduledContactsEvent($this->scheduled ->id,$this->scheduled->group_id,$this->sendContacts)->onQueue('default'));
            //ScheduledContactsEvent::dispatch($this->scheduled ->id,$this->scheduled->group_id,$this->sendContacts);

             return redirect()->to('/campaigns');




    }

    //DELETE CAMPAIGN

    public function removeCampaign(){

        $this->alert('question', 'Delete Campaign '.$this->completeMessageInfo['name'], [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Delete',
            'onConfirmed' => 'confirmedDelete',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onDismissed' => 'cancelled',
            'timer'=>null
        ]);

    }

    public function confirmCampaignRemoval(){
            ScheduledMessage::findOrFail($this->completeMessageInfo['id'])->delete();
            $this->alert('success', 'Campaign has been removed' );
            return redirect(route('campaigns',session('domain')));

    }

    public function dateSelectUpdate($dateString){


     $date =   Carbon::parse( $dateString)->addDays(1)->format('d-m-Y');

    $this->completeMessageInfo['date'] = $date;
    }

    public function optOutUpdate($status){

        $this->completeMessageInfo['optOut'] = $status;
            $this->maxLength =  $status ? 130:160 ;





    }

    public function addBreak(){
//        $this->message = $this->message. "\r\n";
        $this->messageHTML = $this->messageHTML."</p>";
    }

    public function optOutText($contact){

        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $host = \url('/');
        $shortURLObject = $builder->destinationUrl($host.'/optout/'.Crypt::encryptString($contact).'')->secure()->singleUse()->make();
        $shortURL = $shortURLObject->default_short_url;

        return 'OptOut? tap '.$shortURL;
    }




}
