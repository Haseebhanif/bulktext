<?php


namespace App\Http\Traits;


use App\Models\Contact;

trait DataPoints
{


    public function contactOptOuts(){

       $contacts =  Contact::query();
        return [
            'list'=>$contacts->where('active',0)->get(),
            'count'=>$contacts->where('active',0)->count(),
        ];
    }

    public function contactCount(){
        $contacts =  Contact::query();
        return  $contacts->count();
    }

}
