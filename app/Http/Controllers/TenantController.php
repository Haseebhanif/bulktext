<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{


    public function index(){

        $tenant =  Tenant::query();
        return view('tenant.tenant',[
            'tenants'=>$tenant->get(),
            'companies'=>[]
        ]);
    }


    public function branding(){
        return view('tenant.branding',[
            'tenant'=>Tenant::where('domain',session('domain'))->firstOrFail()
        ]);
    }

}
