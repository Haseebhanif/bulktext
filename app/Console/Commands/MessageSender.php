<?php

namespace App\Console\Commands;

use App\Models\ScheduledMessage;
use App\Http\Traits\ChinaMobileAPI;
use App\Models\ScheduledMessageCommandModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageSender extends Command
{

    use ChinaMobileAPI;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:message-sender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This sends sms messages that have been queued';



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //$allScheduled = ScheduledMessageCommandModel::whereHas('contacts')->with('contacts')->where('processed',false)->get();

        $allScheduled = DB::table('scheduled_messages')
            ->where('processed','=',false)
            ->where('acknowledged' ,false)
            ->where('status','=','pending')
            ->where('send_date','<=',  Carbon::now()->format('Y-m-d'))
            ->where('send_time', '<=', Carbon::now()->format('H:i:s'))
//            ->where(function ($query) {
//                $query->where('send_date', '<=', Carbon::now()->format('Y-m-d'))
//                    ->orWhere('send_time', '<=', Carbon::now()->format('H:i:s'));
//            })
            ->join('scheduled_message_contacts', 'scheduled_messages.id','=','scheduled_message_contacts.scheduled_message_id')
            ->where('scheduled_message_contacts.sent','=',0)
            ->get();

//        Log::info('LOG CONTACTS'.json_encode($allScheduled));
        if($allScheduled){
            DB::table('scheduled_messages')
                ->where('processed','=',false)
                ->where('acknowledged' ,false)
                ->where('status','=','pending')
                ->where('send_date','<=',  Carbon::now()->format('Y-m-d'))
                ->where('send_time', '<=', Carbon::now()->format('H:i:s'))
//            ->where(function ($query) {
//                $query->where('send_date', '<=', Carbon::now()->format('Y-m-d'))
//                    ->orWhere('send_time', '<=', Carbon::now()->format('H:i:s'));
//            })
                ->join('scheduled_message_contacts', 'scheduled_messages.id','=','scheduled_message_contacts.scheduled_message_id')
                ->where('scheduled_message_contacts.sent','=',0)
                ->update(['acknowledged'=>true]);
        }


        //no need to capture zero contacts in schedule as relationship only schedule unsent contacts
        foreach ($allScheduled as $contact){

            $response =   $this->sendSingleSMS($contact);
            $this->info(json_encode($response));
            if($response['RESULT_CODE'] == '1'){

                DB::table('scheduled_message_contacts')->where('id',$contact->id)->where('contact_id',$contact->contact_id)->update([
                    'SMS_UID'=> $response['DETAIL_LIST'][0]['SMS_UID'],
                    'RESULT_DESC'=> $response['DETAIL_LIST'][0]['RESULT_DESC'],
                    'RESULT_CODE'=>$response['DETAIL_LIST'][0]['RESULT_CODE'],
                    'sent'=> true
                ]);

            }else{

                DB::table('scheduled_message_contacts')->where('id',$contact->id)->where('contact_id',$contact->contact_id)->update([
                    'RESULT_DESC'=> $response['DETAIL_LIST'][0]['RESULT_DESC'],
                    'RESULT_CODE'=>$response['DETAIL_LIST'][0]['RESULT_CODE']
                ]);
            }

        }


        $SMCM =  ScheduledMessageCommandModel::query();
        $SMCM->where('send_date','<=', Carbon::now()->format('Y-m-d'))
            ->where('send_time','<=',Carbon::now()->format('H:i'))->with('contacts');

        $query = $SMCM->get();

        foreach($query as $q){

            if($q->contacts->count() ==  0){
                $q->processed = true;
                $q->status = 'complete';
                $q->update();

            }

        }


        return Command::SUCCESS;
    }
}
