<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends ResourceCollection
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
                'contacts'=>$item->contacts()->count(),
                'created_at'=>$item->created_at
            ];
        })->toArray();

        return  [
            'status'=>200,
            'data'=>$items,
        ];
    }
}
