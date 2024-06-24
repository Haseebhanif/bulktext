<?php

namespace App\Http\Resources;

use App\Models\Sender;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeptCollection extends ResourceCollection
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


            return [
                'id'=>$item->id,
                'name'=>$item->name,
                'credits'=>$item->credits->amount,
                'senders'=>new SendersCollection(Sender::where('company_id',$item->company_id)->get()),
                'created_at'=>$item->created_at

            ];
        })->toArray();

        return  [
            'status'=>200,
            'data'=>$items,
        ];

    }
}
