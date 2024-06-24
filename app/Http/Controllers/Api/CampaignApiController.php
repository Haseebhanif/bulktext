<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleCampaignBatchRequest;
use App\Http\Requests\ScheduleCampaignRequest;
use App\Http\Resources\CampaignCollection;
use App\Http\Resources\CampaignInformationResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PermissionIssueResource;
use App\Http\Traits\ApiPermissionTrait;
use App\Http\Traits\UsesTeamCredits;
use App\Jobs\ContactsToScheduleAPI;
use App\Models\Group;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use App\Models\Sender;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignApiController extends Controller
{

    public int $charactersPerMessage = 160;

    use ApiPermissionTrait;
    use UsesTeamCredits;
    /**
     * Campaign List
     *
     * Get a paginated list of users from your campaigns. Token Permissions may prevent this from working.
     *
     * @group SMS
     * @authenticated
     * @headers
     * @return CampaignCollection
     */
    public function index(Request $request){
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }

        try {
           return new CampaignCollection(ScheduledMessage::paginate());
        }catch (\Throwable $throwable){
            return  new  ErrorResource($throwable);
        }


    }


    /**
     * View A Campaign
     *
     * Show specific campaign information. Token Permissions may prevent this from working.
     *
     * @group SMS
     * @authenticated
     * @headers
     *
     * @pathParam id integer required
     *   The id of the campaign required
     *
     *
     * @return
     */
    public function show(Request $request,$id){
        if(!$this->permissionCheck('read',$request->user())){
            return new PermissionIssueResource(\request());
        }

        try {
            return new CampaignInformationResource(ScheduledMessage::findOrFail($id));
        }catch (\Throwable $throwable){


            return  new  ErrorResource($throwable);
        }
    }




    /**
     * BULK Send SMS
     *
     * Sending Bulk SMS  requires contacts to be a part of a group. Token Permissions may prevent this from working.
     * Sender ID Value acquired by calling /api/departments
     *
     * @group SMS
     * @authenticated
     * @headers
     *
     * @bodyParam name string required
     * The name of the campaign for referencing Example: New Campaign
     *
     *
     * @bodyParam group_id integer required
     *  The Group id Example: 1
     *
     * @bodyParam sender_id integer required
     * The Sender id Example: 10
     *
     * @bodyParam message string required
     * The message to send Example: This is the text message to send
     *
     * @bodyParam opt_out boolean required
     * Include system set opt out url Example: true
     *
     * @bodyParam send_date string required
     * Send Date of the campaign. Format d-m-Y eg: 01-12-2021 Example: 01-12-2021
     *
     * @bodyParam send_time string required
     * Send Time of the campaign. Format eg: 10:40  Example:10:40
     *
     * @return CampaignInformationResource
     */

    public function scheduleMessage(ScheduleCampaignBatchRequest $request)
    {
        if(!$this->permissionCheck('create',$request->user())){
            return new PermissionIssueResource(\request());
        }

        try {
//             if($request->opt_out){
//                 //generate optout link if we are handling this
//                 $request->opt_out_message;
//             };
//

            //gets message length
            $msgLength = strlen($this->toSMSformat($request->message));



            //creates array by splitting text over 160 characters

            if($msgLength > $this->charactersPerMessage) {
                $messagesToSave = str_split($this->toSMSformat($request->message), $this->charactersPerMessage);
            }else{
                $messagesToSave =[ $this->toSMSformat($request->message)];
            }


            //counts arrays. this shows how many credits will need to be deducted (one per array)
            $creditsUsed = count($messagesToSave);
            $creditsAvailable = $request->user()->currentTeam->credits->amount;


            // checks we have enough credits
            if($creditsUsed <= $creditsAvailable) {

                $this->deductCredits($creditsUsed);
            }else{
                //error
                return'Insufficient credits to complete this schedule';
            }

            $groups =  Group::find($request->group_id);
            if(!$groups){
                return response()->json(['status'=>401,'message'=>'please use valid group']);

            }

            $sender =  Sender::where('id',$request->sender_id)->where('company_id',$request->user()->currentTeam->company->id)->first();
            if(!$sender){
                return response()->json(['status'=>401,'message'=>'please use valid sender id']);

            }


            //add Campaign Schedule for one contact
      $ScheduledMessage =   ScheduledMessage::create(
                [
                    'message'=>$request->message,
                    'variables'=>json_encode([
                        'template'=>  [],
                        'global'=>   []
                    ]),
                    'optout'=>$request->opt_out,
                    //'optout_flag'=>$request->opt_out,
                    'sender_id'=>$sender->sender_name,
                    'group_id'=>$request->group_id,
                    'name'=>  $request->name.' (API Bulk '.Carbon::now()->format('d-m-Y H:i:s').' )',
                    'team_id'=>$request->user()->currentTeam->id,
                    'company_id'=>$request->user()->currentTeam->company->id,
                    'user_id'=>$request->user()->id,
                    'total_credits'=> $creditsUsed,
                    'total_contacts'=> $groups->contacts()->where('active',true)->count(),
                    'send_date'=> Carbon::createFromFormat('d-m-Y', $request->send_date)->format('Y-m-d'),
                    'send_time'=>$request->send_time,
                    'status'=>"importing"
                ]);

            if($ScheduledMessage){
                $company = $request->user()->currentTeam->company->id;
                $rate = $request->user()->currentTeam->company->message_rate;

                dispatch(new ContactsToScheduleAPI(
                    $ScheduledMessage->id,
                    $request->group_id,
                    $company,
                    $rate,
                    $request->message,
                    $request->user()->currentTeam->id
                ));
            }
           return new CampaignInformationResource($ScheduledMessage);

        }catch (\Throwable $throwable){


            return  new  ErrorResource($throwable);
        }
    }


    /**
     * Send Single SMS
     *
     * Single SMS Sending. Token Permissions may prevent this from working.
     * Sender ID Value acquired by calling /api/departments
     *
     * @group SMS
     * @authenticated
     * @headers
     *
     *
     * @bodyParam name string required
     * The name of the campaign for referencing Example: New Campaign
     *
     * @bodyParam sender_id integer required
     * The Sender id Example: 1
     *
     * @bodyParam message string required
     * The message to send Example: 10
     *
     * @bodyParam country_code integer required
     * The country code number without + Example: 44
     *
     * @bodyParam number integer required
     * Number of contact without first 0 or +44 Example: 7979000111
     *
     * @bodyParam send_date string required
     * Send Date of the campaign. Format d-m-Y Example: 01-12-2021
     *
     * @bodyParam send_time string required
     * Send Time of the campaign. Format Example: 10:40
     *
     * @return CampaignInformationResource
     */
    public function singleMessage(ScheduleCampaignRequest $request){
        if(!$this->permissionCheck('create',$request->user())){
            return new PermissionIssueResource(\request());
        }

        try {

         $sender =  Sender::where('id',$request->sender_id)->where('company_id',$request->user()->currentTeam->company->id)->first();
         if(!$sender){
             return response()->json(['status'=>200,'message'=>'campaign removed']);

         }
//             if($request->opt_out){
//                 //generate optout link if we are handling this
//                 $request->opt_out_message;
//             };
//


            //gets message length
            $msgLength = strlen($this->toSMSformat($request->message));



            //creates array by splitting text over 160 characters

            if($msgLength > $this->charactersPerMessage) {
                $messagesToSave = str_split($this->toSMSformat($request->message), $this->charactersPerMessage);
            }else{
                $messagesToSave =[ $this->toSMSformat($request->message)];
            }


            //counts arrays. this shows how many credits will need to be deducted (one per array)
            $creditsUsed = count($messagesToSave);
            $creditsAvailable = $request->user()->currentTeam->credits->amount;


            // checks we have enough credits
            if($creditsUsed <= $creditsAvailable) {

                $this->deductCredits($creditsUsed);
            }else{
                //error
                return'Insufficient credits to complete this schedule';
            }

                //add Campaign Schedule for one contact
             $messageInfo =   tap(ScheduledMessage::create(
                    [
                        'message'=>$request->message,
                        'variables'=>json_encode([
                            'template'=>  [],
                            'global'=>   []
                        ]),
                        'optout'=>false,
                        //'optout_flag'=>false,
                        'sender_id'=> $sender->sender_name,
                        'group_id'=>0,
                        'name'=>  $request->name.' (API SSM '.Carbon::now()->format('d-m-Y H:i:s').' )',
                        'team_id'=>$request->user()->currentTeam->id,
                        'company_id'=>$request->user()->currentTeam->company->id,
                        'user_id'=>$request->user()->id,
                        'total_credits'=> $creditsUsed,
                        'total_contacts'=> 1,
                        'send_date'=> Carbon::createFromFormat('d-m-Y', $request->send_date)->format('Y-m-d'),
                        'send_time'=>$request->send_time,
                        'status'=>"pending"
                    ]),
                    function (ScheduledMessage $scheduledMessage)use($request,$creditsUsed,$sender){


                        //Add Contact for  Campaign Schedule for one contact
                        ScheduledMessageContacts::create([
                                'scheduled_message_id'=>$scheduledMessage->id,
                                'sender_id'=>$sender->sender_name,
                                'contact_id'=>0,
                                'message_sent'=>$request->message,
                                'sms_qty'=> $creditsUsed ,
                                'number'=>$request->number,
                                'credits_used'=>$creditsUsed,
                                'team_id'=>$request->user()->currentTeam->id,
                                'company_id'=>$request->user()->currentTeam->company->id,
                                'sms_rate'=>$creditsUsed,
                                'country_code'=>$request->country_code,
                        ]);
                        //return information on campaign created
                        return new CampaignInformationResource($scheduledMessage);
                    });

            return new CampaignInformationResource($messageInfo);

        }catch (\Throwable $throwable){


            return  new  ErrorResource($throwable);
        }
    }

    /**
     * Delete Campaign
     *
     * Remove a specific campaign. Token Permissions may prevent this from working.
     *
     * @param Request $request
     * @authenticated
     * @group SMS
     * @pathParam id integer required
     *  The id of the campaign required
     *
     * @response {
     *       "status": 200,
     *        "message": "campaign removed"
     *
     *  }
     *
     **/

    public function removeCampaign(Request $request ,$id){

        if(!$this->permissionCheck('delete',\request()->user())){
            return new PermissionIssueResource(\request());
        }
        try{

         $campaign = ScheduledMessage::findOrFail($id);
         $campaign->delete();
         ScheduledMessageContacts::where('scheduled_message_id',$id)->delete();
            return response()->json(['status'=>200,'message'=>'campaign removed']);

        }catch (\Throwable $throwable){
            return  new  ErrorResource($throwable);

        }

    }



    private function toSMSformat($message){
        $options = array(
            'ignore_errors' => true,
            'drop_links'=>true
        );


        return \Soundasleep\Html2Text::convert($message, $options);
    }



}
