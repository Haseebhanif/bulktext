<?php

namespace App\Http\Resources;

use App\Models\Sender;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SendersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return $this->collection->map(function($item, $key){
            return [
                'id'=>$item->id,
                'sender_name'=>$item->sender_name,
            ];
        })->toArray();



    }
}
