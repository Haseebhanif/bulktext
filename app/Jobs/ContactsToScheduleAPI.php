<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\ScheduledMessageContacts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ContactsToScheduleAPI implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 400;

    public $scheduleId;
    public $contactGroupId;

    public $message;

    public $contacts;

    public $companyId;
    public $rate;
    public $team;
    public $charactersPerMessage = 160;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scheduleId,$contactGroupId,$companyId,$rate,$message,$team)
    {
        $this->scheduleId =$scheduleId;
        $this->contactGroupId = $contactGroupId;
        $this->companyId = $companyId;
        $this->message = $message;
        $this->rate = $rate;
        $this->team = $team;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

       $scheduledMessage = DB::table('scheduled_messages')->find($this->scheduleId);

       if($scheduledMessage->optout == true){
           $this->charactersPerMessage = 130;
       }


       $contacts = DB::table('groups')

            ->where('contacts.team_id',$this->team)
            ->join('group_contacts','group_contacts.group_id','groups.id')
           ->join('contacts','group_contacts.contact_id','contacts.id')
           ->select('contacts.number','contacts.country_code','contacts.id','contacts.active')
           ->get();
        //gets message length


        $msgLength = strlen($this->toSMSformat($this->message));

        //creates array by splitting text over 160 or 130 if opt out characters
        if($msgLength > $this->charactersPerMessage) {
            $messagesToSave = str_split($this->toSMSformat($this->message), $this->charactersPerMessage);
        }else{
            $messagesToSave =[ $this->toSMSformat($this->message)];
        }



        //counts arrays. this shows how many credits will need to be deducted (one per array)
       $creditsUsed = count($messagesToSave);
       foreach ($contacts as $contact) {

           if ($contact->active == true) {
               DB::table('scheduled_message_contacts')->insert([
                   'scheduled_message_id' => $scheduledMessage->id,
                   'sender_id' => $scheduledMessage->sender_id,
                   'contact_id' => $contact->id,
                   'message_sent' => $scheduledMessage->optout ? $this->message .' '.$this->optOutText($contact->id):$this->message,
                   'sms_qty' => $creditsUsed,
                   'number' => $contact->number,
                   'credits_used' => $creditsUsed,
                   'team_id' => $this->team,
                   'company_id' => $this->companyId,
                   'sms_rate' => $this->rate,
                   'country_code' => $contact->country_code,

               ]);
           }
       }

        DB::table('scheduled_messages')->where('id',$this->scheduleId)->update(['status'=>'pending']);
    }


    public function optOutText($contact,$optText = null){

        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $host = \url('/');
        $shortURLObject = $builder->destinationUrl(env('OPTOUT_URL').'/optout/'.Crypt::encryptString($contact).'')->secure()->singleUse()->make();
        $shortURL = $shortURLObject->default_short_url;

        return 'OptOut? tap '.$shortURL;
    }


    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );


        return \Soundasleep\Html2Text::convert($message, $options);
    }

}
