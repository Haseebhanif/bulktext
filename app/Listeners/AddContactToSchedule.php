<?php

namespace App\Listeners;

use App\Events\ScheduledContactsEvent;
use App\Http\Livewire\Contact\Contacts;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\CustomContactInfo;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AddContactToSchedule
{

    public $completeMessageInfo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ScheduledContactsEvent  $event
     * @return void
     */
    public function handle(ScheduledContactsEvent $event)
    {



        $scheduledMessage = ScheduledMessage::find($event->scheduleId);




//        $contactGroup = ContactGroup::select('contacts.*','group_contacts.group_id')
//                        ->where('group_id',$event->contactGroupId)
//                        ->join('contacts','contacts.id','=','group_contacts.contact_id','left')
//                        ->join('custom_contact_infos','custom_contact_infos.contactable_id','=','contacts.id','left')
//                        ->where('contacts.active',1)
//                        ->get();



        foreach ($event->contacts as $contact){

                    $contact['preview'] = $contact['preview'] . ' ' . $this->optOutText($contact['id']);
                  ScheduledMessageContacts::create(

                    [
                        'scheduled_message_id'=>$scheduledMessage->id,
                        'sender_id'=>$scheduledMessage->sender_id,
                        'contact_id'=>$contact['id'],
                        'message_sent'=>$contact['preview'],
                        'sms_qty'=> strlen($contact['credits']) ,
                        'number'=>$contact['number'],
                        'credits_used'=>$contact['credits'],
                        'team_id'=>$contact['team_id'],
                        'company_id'=>Auth::user()->currentTeam->company->id,
                        'sms_rate'=>Auth::user()->currentTeam->company->message_rate,
                        'country_code'=>$contact['country_code']
                    ]);

            }

    }



    public function optOutText($contact){

        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $host = \url('/');
        $shortURLObject = $builder->destinationUrl($host.'/optout/'.Crypt::encryptString($contact).'')->secure()->singleUse()->make();
        $shortURL = $shortURLObject->default_short_url;

        return 'OptOut? tap '.$shortURL;
    }


    function string_between_two_string($str, $starting_word, $ending_word){
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
        return '';
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

    private function contactVarReplace($value,$contact){

        Log::info('PLACEHOLDER: '.$value);

        switch($value){
            case '[company_name]':
                return Team::find($contact->team_id)->company->company_name;
            case '[number]':
                return $contact->number;
            default:
                $removeBracket = str_replace(["[","]"],"","$value");
                $data  =  CustomContactInfo::where('contactable_id',$contact->id)->where('custom_name',$removeBracket)->first();
                return $data->custom_value;
        }


        if (str_contains($value,'custom_')) {


            return $data->custom_value;



            if($contact->custom_name && mb_strtolower($contact->custom_name) == mb_strtolower($string)){
                return $contact->custom_value;
            }

        }




    }

}
