<?php

namespace App\Jobs;

use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use http\Client\Curl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ContactsToSchedule implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 400;

    public $scheduleId;
    public $contactGroupId;

    public $contacts;

    public $companyId;
    public $rate;
    public $baseUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scheduleId,$contactGroupId,$contacts,$companyId,$rate,$baseUrl)
    {
        $this->scheduleId =$scheduleId;
        $this->contactGroupId = $contactGroupId;
        $this->contacts = $contacts;
        $this->companyId = $companyId;
        $this->rate = $rate;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $scheduledMessage = DB::table('scheduled_messages')->find($this->scheduleId);




        foreach (json_decode($this->contacts,true) as $contact){

            $contact['preview'].=  $scheduledMessage->optout  == true ? $this->optOutText($contact['id']) : '';

            DB::table('scheduled_message_contacts')->updateOrInsert(
                [
                    'scheduled_message_id'=>$scheduledMessage->id,
                    'sender_id'=>$scheduledMessage->sender_id,
                    'contact_id'=>$contact['id'],
                ],
                [
//                    'scheduled_message_id'=>$scheduledMessage->id,
//                    'sender_id'=>$scheduledMessage->sender_id,
//                    'contact_id'=>$contact['id'],
                    'message_sent'=>$contact['preview'],
                    'sms_qty'=> strlen($contact['credits']) ,
                    'number'=>$contact['number'],
                    'credits_used'=>$contact['credits'],
                    'team_id'=>$contact['team_id'],
                    'company_id'=>$this->companyId,
                    'sms_rate'=>$this->rate,
                    'country_code'=>$contact['country_code']
                ]);

        }
        DB::table('scheduled_messages')->where('id',$this->scheduleId)->update(['status'=>'pending']);




    }



    public function optOutText($contact,$optText = null){


        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        $shortURLObject = $builder->destinationUrl($this->baseUrl.'/optout/'.Crypt::encryptString($contact).'')->secure()->singleUse()->make();
        $shortURL = $shortURLObject->default_short_url;

       // $shortURL = $this->baseUrl.''.$shortURLObject->default_short_url;

        return 'OptOut? tap '.$shortURL;
    }
}
