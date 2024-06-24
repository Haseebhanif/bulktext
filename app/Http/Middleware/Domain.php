<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use NunoMaduro\Larastan\Methods\Pipes\Auths;

class Domain
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
        $tenant = Tenant::query();

        $url =  \request()->getHost();
        $containsDomain = false;

        $url =  \request()->getHost();
        $parts = explode('.', $url);
        $subdomain = $parts[0];

        $topLevelDomains = explode(',', config('app.top_level_domains'));


        foreach ($topLevelDomains as $domain) {
            if (Str::contains($url, $domain)) {
                $containsDomain = true;
                break; // Exit the loop if a match is found
            }
        }

        if (env('APP_CENTRAL') !== $request->domain ){




//            $url =  \request()->getHost();
//            $topLevelDomains = explode(',', config('app.top_level_domains'));
//
//
//            foreach ($topLevelDomains as $domain) {
//                if (Str::contains($url, $domain)) {
//                    $containsDomain = true;
//                    break; // Exit the loop if a match is found
//                }
//            }


            if ( Tenant::query()
                    ->when($url, function ($query) use ($url) {
                        return $query->where('domain', $url);
                    })
                    ->when($subdomain, function ($query) use ($subdomain) {
                        return $query->orWhere('domain', $subdomain);
                    })->count()== 0 ) {
               //  return redirect('https://'.env('APP_CENTRAL').'.'.env('DOMAIN'));
                return abort(401);

            }else{



               $domain = Tenant::query()
                   ->when($url, function ($query) use ($url) {
                       return $query->where('domain', $url);
                   })
                   ->when($subdomain, function ($query) use ($subdomain) {
                       return $query->orWhere('domain', $subdomain);
                   })->firstOrFail();



                if (Auth::check()) {



                   $belongsToCompany =  Company::findOrFail(Auth::user()->current_company_id);


//                   dd($domain->id ,$belongsToCompany->tenant_id,Auth::user()->tenant_id);

                    if($domain->id == $belongsToCompany->tenant_id && Auth::user()->tenant_id == $belongsToCompany->tenant_id){
                        return $next($request);
                    }else{

                        if($containsDomain){

                            $prefix = str_replace(['.','-'],'',$url);
                            return redirect(route($request->route()->getName(),['domain' => $belongsToCompany->tenantParent->domain]));


                        } else{
                            return redirect(route($request->route()->getName(),['domain' => $belongsToCompany->tenantParent->domain]));
                        }
                    }


                }


            }

        }

       return $next($request);
    }
}
