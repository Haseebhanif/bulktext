<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = $this->collection->map(function($item, $key){

            return new CampaignResource($item);
        })->toArray();

        return  [
            'data'=>$items,
            'meta' => [
                'total_results' => count($this->collection)
            ],
        ];
    }
}
