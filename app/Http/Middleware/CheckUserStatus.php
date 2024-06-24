<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $host =  $request->getHost();
        $prefix = str_replace(['.','-'],'',$host);

        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            $tenant = Tenant::find($user->tenant_id);

            // Check if both current_team_id and current_company_id are set (not 0)
            if ($user->current_team_id == 0 || !$user->current_team_id) {
                // User has both team ID and company ID, continue to the intended destination

                if($tenant->istld){
                    return redirect()->route($prefix.'.holding.screen',['domain'=>$tenant->domain]);
                }else{
                    return redirect()->route('holding.screen',['domain'=>$tenant->domain]);
                }

            }


            // Check if both current_team_id and current_company_id are set (not 0)
            if ($user->current_team_id != 0 && $user->current_company_id != 0) {
                // User has both team ID and company ID, continue to the intended destination
                return $next($request);
            }
            if($tenant->istld){
                return redirect()->route($prefix.'.holding.screen',['domain'=>$tenant->domain]);
            }else{
                return redirect()->route('holding.screen',['domain'=>$tenant->domain]);
            }

        }

        // If user is not logged in, redirect to login page
        return redirect()->route('login');
    }
}
