<?php

namespace App\Http\Traits;

use App\Models\EmailService;
use App\Models\Tenant;

trait EmailConfigSettingTrait
{

    public function checkCustomEmail(){

        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));
        $tenant = Tenant::where('domain', $domain)->first();
        if ($tenant) {
            $customSMTP =   EmailService::where('tenant_id',$tenant->id)->first();
            if($customSMTP){
                return $customSMTP;
            }
        }else{
            return false;
        }
    }

    public function  emailBranding(){

        $branding = collect([
            'logo' => null, 'login' => null, 'register' => null, 'colour1' => null, 'colour2' => null, 'tenant_name' => null, 'domain' => null, 'tenant_name' => 'SMS Portal'
        ]);


        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));
        $tenant = Tenant::where('domain', $domain)->first();
        if ($tenant) {

            // The "users" table exists...
            $branding = $tenant->select('logo', 'login', 'register', 'colour1', 'colour2', 'tenant_name', 'domain')->where('domain', $domain)->first();
        }

        return $branding;

    }

}
