<?php

namespace App\Http\Middleware;

use App\Models\EmailService;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ConfigureMail
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = $this->getCurrentTenant();


        if(isset($tenant->smtp)){


            // Dynamically set mail configuration
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', $tenant->smtp);
            Config::set('mail.mailers.smtp.port', $tenant->port);
            Config::set('mail.mailers.smtp.encryption', $tenant->encryption);
            Config::set('mail.mailers.smtp.username', $tenant->username);
            Config::set('mail.mailers.smtp.password', decrypt($tenant->password));
            Config::set('mail.from.address', $tenant->email);
            Config::set('mail.from.name', $tenant->name);

            config('mail.default', 'smtp');
            config('mail.mailers.smtp.host', $tenant->smtp);
            config('mail.mailers.smtp.port', $tenant->port);
            config('mail.mailers.smtp.encryption', $tenant->encryption);
            config('mail.mailers.smtp.username', $tenant->username);
            config('mail.mailers.smtp.password', decrypt($tenant->password));
            config('mail.from.address', $tenant->email);
            config('mail.from.name', $tenant->name);
            Log::info("CONFIG MAIL ".json_encode(config('mail.mailers')));

            return $next($request);

        }else{
            return $next($request);
        }

    }

    private function getCurrentTenant()
    {

        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));
        $tenant = Tenant::where('domain',$domain)->first();



        if($tenant){
            Session::put('branding', $tenant);
            return EmailService::where('tenant_id',$tenant->id)->first();
        }
    }


}
