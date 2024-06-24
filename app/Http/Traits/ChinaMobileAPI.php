<?php


namespace App\Http\Traits;


use Carbon\Carbon;
use http\Client\Request;
use Illuminate\Support\Facades\Http;

use function Symfony\Component\Translation\t;

trait ChinaMobileAPI
{
    use PerSendSMSTrait;


    public $url;
    public $auth;
    public $client;



    public function testSMS(){

        $data = [
            'ROUTE_ID'=>env('CM_ROUTE_ID'),
            'SENDER_ID'=>"TM2",
            'METHOD'=>'SMS_SEND_REQUEST',
            'TYPE'=>'REQUEST',
            'ORIGINAL_ADDR'=>"TM2",
            'AUTH_KEY'=>env('CM_AUTH_KEY'),
            'SERIAL'=>1,
            'MULTI_MSISDN_LIST'=>[
                [
                    "DEST_MSISDN"=> "7939003258",
                    "COUNTRY_CODE"=> 44
                ],
                [
                    "DEST_MSISDN"=> "7580685829",
                    "COUNTRY_CODE"=> 44
                ],
            ],
            "SMS_CONTENT"=>"Offer  Message ",
            'TIME'=> (string) Carbon::now(),//'2022-10-21 17:58:37',
            "PRIORITY"=> 1,
//            "SIGNATURE"=> "CloudSMS", # If sending to mainland China or overseas where there is a regulatory need, you need to apply to CloudSMS in advance
//            "SIGNATURE_TYPE"=> 3,
//            "ORIGINAL_ADDR"=> "CloudSMS", # Not required. If it is not filled in or the v alue is empty, the default value Cloud is usedSMS
            'VERSION'=>"2021-01-01",
        ];

        try{
            $response =  Http::withHeaders(
                [
                    'AUTH_KEY'=>env('CM_AUTH_KEY')
                ]
            )->post(env('CM_SMS_URL_LIVE'),$data);
            dd($response, $this->responseCheck($response->body()));


        }catch (\Throwable $throwable){
            dd($throwable);
            return $throwable;
        }

    }



    public function sendSingleSMS($recipients){

      $contactList =  $this->contactMappingSingle($recipients);


      $data = [
            'ROUTE_ID'=>env('CM_ROUTE_ID'),
            'SENDER_ID'=>"$recipients->sender_id",
            'METHOD'=>'SMS_SEND_REQUEST',
            'TYPE'=>'REQUEST',
            'ORIGINAL_ADDR'=>"$recipients->sender_id",
            'AUTH_KEY'=>env('CM_AUTH_KEY'),
            'SERIAL'=>1,
            'MULTI_MSISDN_LIST'=>
                [
                $contactList //formatted as array
                ],
            "SMS_CONTENT"=>"$recipients->message_sent",
            'TIME'=> (string) Carbon::now(),//'2022-10-21 17:58:37',
            "PRIORITY"=> 1,
//            "SIGNATURE"=> "CloudSMS", # If sending to mainland China or overseas where there is a regulatory need, you need to apply to CloudSMS in advance
//            "SIGNATURE_TYPE"=> 3,
//            "ORIGINAL_ADDR"=> "CloudSMS", # Not required. If it is not filled in or the v alue is empty, the default value Cloud is usedSMS
            'VERSION'=>"2021-01-01",
        ];
       try{
           $response =  Http::withHeaders(
               [
                   'AUTH_KEY'=>env('CM_AUTH_KEY')
               ]
           )->post(env('CM_SMS_URL_LIVE'),$data);
             return $this->responseCheck($response->body());
       }catch (\Throwable $throwable){
           dd($throwable);
           return $throwable;
       }


    }

    public function deliveryReports(){





        $data = [

            'TYPE'=>'REQUEST',
            'SERIAL'=>2,
            'TIME'=> (string) Carbon::now(),//'2022-10-21 17:58:37',
            "SOURCE_MSISDN"=> "CloudSMS",
            'SMS_UID'=>'5F3B5E66CB277X601HFA163E9DC506',

        ];

        try{
            $response =  Http::withHeaders(
                [
                    'AUTH_KEY'=>'cOUlfIimjcBgfxf5cNaiOfTjZm3HWH0gS5tlhb9cGKA+qNE1YFy8KnkOi#awjIJoz+#mazLwrvLbc7vynfnVBA=='
                ]
            )->post(env('CM_SMS_URL_LIVE'),$data);
            return $this->responseCheck($response->body());
        }catch (\Throwable $throwable){
            dd($throwable);
            return $throwable;
        }



    }





    public function responseCheck($response)
    {
        $response = json_decode($response,true);
//        if (method_exists($response, 'RESULT_DESC') && method_exists($response, 'RESULT_CODE')) {
//            $statusCode = $response->status();
//        }

        switch (strtoupper($response['RESULT_DESC'])) {
            case 'OK':
                $response['message'] = 'OK';
                return $response;
            case 'UNKNOWN_ERROR':
                $response['message'] = 'Unknown Exception Error';
                return $response;
            case 'BUSY':
                $response['message'] = 'Retry in a few minutes';
                return $response;ak;
            case 'EMPTY_DATA':
                $response['message'] = 'No data found to be sent. please check and retry';
                return $response;
            case "CHANNEL_NOT_EXIST":
                $response['message'] = 'Please check auth keys';
                return $response;
            case 'INVALIDE_PARAMETER':
                $response['message'] = 'Parameter information formatted incorrectly ';
                return $response;

            case 'INVALID_CONTEXT':
                $response['message'] = 'Check that data sent is in json format 0x10000003';
                return $response;

            case 'SEND_FAILED':
                $response['message'] = 'Error sending SMS 0x10000004';
                return $response;

            case 'QUEUE_TO_LARGE':
                $response['message'] = 'SMS queue service cache is full , please try again in a few moments.';
                return $response;
            case 'INTERCEPT':
                $response['message'] = 'These messages have been intercepted and possibly blacklisted';
                return $response;
            case 'LOST_INFO':
                $response['message'] = 'Incomplete package data partial loss.';
                return $response;
            case 'EMPTY_DATA':
                $response['message'] = 'Received empty data';
                return $response;
            case 'DB_NOT_FIND':
                $response['message'] = 'Data Storage error';
                return $response;
            case 'UNPRICED_AREA':
                $response['message'] = 'Price not allow to be sent in this area.';
                return $response;
            case 'INVALID_VERSION':
                $response['message'] = 'Api version invalid.';
                return $response;
            default:
                return $response;
        }
    }
//
//        [
//            +"RESULT_CODE": 1
//        +"RESULT_DESC": "OK"
//        +"DETAIL_LIST": array:1 [▶
//    0 => {#1457 ▶
//            +"RESULT_CODE": 1
//            +"RESULT_DESC": "OK"
//            +"DEST_MSISDN": "7939003258"
//            +"COUNTRY_CODE": 44
//            +"SMS_UID": "5EB89B5D3FED3XBF6HFA163E017E52"
//    }
//  ]
//  +"METHOD": "SMS_SEND_REQUEST"
//        +"TYPE": "ANSWER"
//        +"SERIAL": 1
//        +"TIME": "2022-10-21 19:26:17"
//        ]
//    }



}
