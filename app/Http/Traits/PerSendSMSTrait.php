<?php


namespace App\Http\Traits;


trait PerSendSMSTrait
{


    /**
     * Formats contacts for CM SMS Single
     * @param $recipients
     * @return array|mixed
     */
    public function contactMappingSingle($contact){
        // handles zero contacts
        if(!$contact){
            return [];
        }

        // formats contact details
            return  [
                "DEST_MSISDN"=> "$contact->number",
                "COUNTRY_CODE"=> $contact->country_code
            ];
    }

    /**
     * Formats contacts for CM SMS
     * @param $recipients
     * @return array|mixed
     */
    public function contactMappingMulti($recipients){
        // handles zero contacts
        if(!$recipients){
            return [];
        }
        // formats contact details
        return  $recipients->map(function ($contact){
                return  [
                            "DEST_MSISDN"=> "$contact->number",
                            "COUNTRY_CODE"=> $contact->country_code
                        ];
            });
    }

    public function messageChecking($message){

        //charecter limit

        //split over meessaging


    }



}
