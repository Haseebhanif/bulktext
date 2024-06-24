<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyContoller extends Controller
{


    public function index(){


        return view('company.branding',[
            'company'=>Auth::user()->currentTeam->company
        ]);
    }

    public function show(){



        return view('company.details',[
            'company'=>Auth::user()->currentTeam->company
        ]);
    }

    public function delete(Company $company, Request $request){

        $teamId =  $company->team->id;
        $companyId =  $company->id;

        dd($companyId, $teamId);

//        if($company->company_name == $request->name){
//
//
//
//
//
//
//                $company->delete();
//
//        }


    }

}
