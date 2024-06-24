<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class DynamicSessionDomain
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




         $host = $request->getHost();
        if (Str::contains($host,'moloffical.club')) {

            config(['app.name' => 'Moloffical']);
            config(['app.url' => 'https://moloffical.club']);
            config(['app.main_url' => 'https://moloffical.club']);
            config(['app.domain' => 'moloffical.club']);
            config(['app.asset_url' => 'https://moloffical.club/']);
//            config(['session.domain' => 'moloffical.club']);
//            config(['session.cookie' => env('SESSION_COOKIE', Str::slug('moloffical_club', 'laravel').'_session')]);

        }
//        elseif  (Str::contains($host,env('OPTOUT_URL'))) {
//            config(['app.name' => 'notext']);
//            config(['app.url' => env('OPTOUT_URL')]);
//            config(['app.main_url' => env('OPTOUT_URL')]);
//            config(['app.domain' => env('OPTOUT_URL')]);
//            config(['app.asset_url' => env('OPTOUT_URL')]);
//        }


        elseif  (Str::contains($host,'textmanagementportal.co.uk')) {
            config(['app.name' => 'Text Management']);
            config(['app.url' => 'https://textmanagementportal.co.uk']);
            config(['app.main_url' => 'https://textmanagementportal.co.uk']);
            config(['app.domain' => 'textmanagementportal.co.uk']);
            config(['app.asset_url' => 'https://textmanagementportal.co.uk/']);
//            config(['session.domain' => 'textmanagementportal.co.uk']);
//            config(['session.cookie' => env('SESSION_COOKIE', Str::slug('textmanagementportal', 'laravel').'_session')]);
        }


        else{
            // Set other domain-specific configurations}
            // Default to .microsite.website or handle other cases as needed
//            config(['session.domain' => '.microsite.website']);
        }



        return $next($request);
    }
}
