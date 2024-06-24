<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'sender_id'=>$this->sender_id,
            'status'=>$this->status,
            'message'=>$this->message,
            'send_date'=>$this->send_date,
            'send_time'=>$this->send_time,
            'contacts'=>$this->contacts()->count(),
            'created_at'=>$this->created_at,
            'processed'=>$this->processed
        ];
    }
}
