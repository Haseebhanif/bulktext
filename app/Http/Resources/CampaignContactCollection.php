<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignContactCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = $this->collection->map(function($item, $key){
            return
                [
                    'country_code'=>$item->country_code,
                    'number' => $item->number,
                    'message'=>$item->message_sent,
                    'sms_qty'=>$item->sms_qty,
                    'used_credits'=>$item->credits_used,
                    'UID'=>$item->SMS_UID,
                    'received'=>$item->RESULT_CODE,
                    'sent'=>$item->sent,
                    'delivery_report_type'=>$item->dr_type,
                    'delivery_report_response'=>$item->dr_response
                ];
        })->toArray();

        return  [
            'data'=>$items,
            'meta' => [
                'total_results' => count($this->collection)
            ],
        ];
    }

}
