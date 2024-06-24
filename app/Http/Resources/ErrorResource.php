<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\String\s;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         return  $this->message($this->getCode(),$this->getMessage());


    }

    private function message($code,$message){

        switch ($code){

            case 0:
                return [
                    'message'=>str_replace(['[App\Models\\',']'],'',$message),
                    'code'=>'404'];

            default :
                return
                    [
                        'message'=>$this->getMessage(),
                        'code'=>$this->getCode()];


        }


    }
}
