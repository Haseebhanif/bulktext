<?php

namespace App\Http\Livewire\Message\SendMessage;

use App\Http\Traits\UserDefinedVars;
use App\Http\Traits\UsesTeamCredits;
use App\Models\Contact;
use App\Models\MessageTemplate;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TextAreaInfo extends Component
{
    use WithPagination;
    use UsesTeamCredits;
    public $name;
    public $message;
    public $messageAfterVars;
    public $messagesToSave;
    public $length=0;
    public $maxLength = 160;
    public $sendMessageStatus ='pending';

    public $variables = [];

    public $contactVariables = [];

    public $completeMessageInfo = [
      'name'=>null,
      'message'=>null,
      'contacts'=>[],
      'vars'=> [],
      'totalCredits'=>0
    ];
    public $contactList = [];
    public $totalCredits = 0;


    protected $listeners = ['templateSelected'=> 'updateTextarea','scheduleGroupClick'=>'selectedContactGroup'];
    use UserDefinedVars;


    public function render()
    {
        $this->contactVariables =  $this->userVars();
        $this->characterCount();
       return view('livewire.message.send-message.text-area-info',[
            'message'=>$this->message,
            'count'=>$this->length,
            'contacts'=> $this->refactorContactsOnMessageUpdate()
        ]);
    }

    public function characterCount(){

        $this->messageAfterVars = $this->message;

        foreach ($this->variables as $value){

            if($value['value'] && $value['placeholder']){
                $this->messageAfterVars = str_replace($value['placeholder'], $value['value'],$this->messageAfterVars);
            }

        }

        $this->length =  strlen($this->toSMSformat($this->messageAfterVars));



        if($this->length > $this->maxLength) {
            $this->messagesToSave = str_split($this->toSMSformat($this->messageAfterVars), $this->maxLength);
        }else{
            $this->messagesToSave =[ $this->toSMSformat($this->messageAfterVars)];
        }

       $this->emit('messageUpdate',$this->messagesToSave);
    }

    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );


        return \Soundasleep\Html2Text::convert($message, $options);
    }

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

    }

    public function sendMessage(Request $request){

//        $this->validate([
//           'messagesToSave.message'=>'array:0',
//           'completeMessageInfo.contacts'=>'array:0'
//        ]);


        tap(ScheduledMessage::create([
           'message'=>$this->message,
           'variables'=>json_encode([
               'template'=>  $this->variables,
               'global'=>   $this->contactVariables
           ]),
            'team_id'=>Auth::user()->currentTeam->id,
            'company_id'=>Auth::user()->currentTeam->company->id,
            'user_id'=>Auth::user()->id,
            'total_credits'=> $this->totalCredits,
            'send_date'=>Carbon::now()->format('Y-m-d'),
            'send_time'=>Carbon::now()->format('H:i'),
            'status'=>'pending'
        ]),function (ScheduledMessage $scheduledMessage){

            $contacts = $this->refactorContactsOnMessageUpdate();

            if($this->totalCredits > Auth::user()->currentTeam->credits->amount){
                $scheduledMessage->status = 'draft';
                $scheduledMessage->update();
            }

              foreach ($contacts as $contact){
                  if($this->totalCredits > Auth::user()->currentTeam->credits->amount) {
                      $this->deductCredits($contact['credits']);
                  }
                  ScheduledMessageContacts::create(
                      [
                          'scheduled_message_id'=>$scheduledMessage->id,
                          'message_sent'=>$contact['preview'],
                          'sms_qty'=> $contact['characters'] % $this->maxLength,
                          'number'=>$contact['number'],
                          'credits_used'=>$contact['credits'],
                          'team_id'=>$contact['team_id'],
                          'company_id'=>Auth::user()->currentTeam->company->id,
                          'sms_rate'=>Auth::user()->currentTeam->company->message_rate,
                          'country_code'=>$contact['country_code']
                      ]);
              }
        });


        $this->emit('creditUpdate');
        if($this->totalCredits > Auth::user()->currentTeam->credits->amount){
            session()->flash('message', 'Campaign  Draft saved successfully! Please Add more credits to send.');
        }else{
            session()->flash('message', 'Campaign successfully added.');
        }

        return redirect()->to('/campaigns');
    }



    public function refactorContactsOnMessageUpdate(){

        $this->totalCredits = 0;
       if(count($this->completeMessageInfo['contacts']) == 0){
           $this->completeMessageInfo['contacts'] = [];
           return [];
       }

        $contacts =  tap(Contact::select('firstname','lastname','title','active','number','country_code','team_id')
            ->whereIn('id',$this->completeMessageInfo['contacts'])->paginate(25)
        )->map(function ($item){

            $contactMessage = $this->message;
            foreach ($this->variables as $value){

                if($value['value'] && $value['placeholder']){
                    $contactMessage =   str_replace($value['placeholder'], $value['value'],  $contactMessage);
                }

            }
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


        $this->completeMessageInfo['totalCredits']  = $this->totalCredits;
        return $contacts;
    }

    private function contactVarReplace($value,$contact){


        switch($value){
            case '[company_name]':
                return Team::find($contact->team_id)->company->company_name;
            case '[first_name]':
                return $contact->firstname;
            case '[last_name]':
                return $contact->lastname;
            case '[title]':
                return $contact->title;
            case '[name]':
                return $contact->title.' '.$contact->firstname.' '.$contact->lastname;
        }



    }



    public function selectedContactGroup($contacts){
        $this->completeMessageInfo['contacts'] = $contacts;
        $this->contactList = $contacts;

    }
}
