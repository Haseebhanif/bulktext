<?php


namespace App\Http\Traits;


use App\Models\CustomContactInfo;
use Illuminate\Support\Facades\Auth;

trait UserDefinedVars
{

    public function userVars(){

        $variables = [
            [
            'placeholder'=>'[company_name]',
            'info'=>'The company the message is sent from'
        ],
            [
                'placeholder'=>'[number]',
                'info'=>'The contacts number'
            ]
            ];
      CustomContactInfo::select('custom_name','team_id')->where('team_id',Auth::user()->currentTeam->id)->groupBy('custom_name','team_id')->get()->map(function ($item) use (&$variables) {
            $variables[] = [
                'placeholder'=>'['.$item->custom_name.']',
                'info'=>$item->custom_name,
            ];
        });

        return $variables;

    }

}
