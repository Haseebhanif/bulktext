<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
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
        if(is_null($item)){
            return null;
        }
        return new ContactResource($item);
    })->toArray();

      return  [
       'data'=>$items,
        'meta' => [
             'total_results' => count($this->collection)
            ],
        ];
    }
}
