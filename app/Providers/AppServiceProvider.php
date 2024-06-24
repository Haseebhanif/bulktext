<?php

namespace App\Providers;

use App\Jobs\ContactsToSchedule;
use App\Models\EmailService;
use App\Models\StripePerTenant;
use App\Models\Team;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {



        Session::remove('domain');
        Session::remove('branding');
        //
        $domain = str_replace(['.' . env('DOMAIN'), 'https://', 'http://'], '', \url('/'));


        $tenant = Tenant::where('domain', $domain)->first();

        $tem = $this->getCurrentTenant();
        if (isset($tem->smtp)) {
            // Dynamically set mail configuration
            Config::set('mail.mailers.smtp.host', $tem->smtp);
            Config::set('mail.mailers.smtp.host', $tem->smtp);
            Config::set('mail.mailers.smtp.port', $tem->port);
            Config::set('mail.mailers.smtp.encryption', $tem->encryption);
            Config::set('mail.mailers.smtp.username', $tem->username);
            Config::set('mail.mailers.smtp.password', $tem->password);
            Config::set('mail.from.address', $tem->email);
            Config::set('mail.from.name', $tem->name);


            config('mail.mailers.smtp.host', $tem->smtp);
            config('mail.mailers.smtp.port', $tem->port);
            config('mail.mailers.smtp.encryption', $tem->encryption);
            config('mail.mailers.smtp.username', $tem->username);
            config('mail.mailers.smtp.password', $tem->password);
            config('mail.from.address', $tem->email);
            config('mail.from.name', $tem->name);

        }


        if ($tenant) {

            // The "users" table exists...
            $branding = $tenant->select('logo', 'login', 'register', 'colour1', 'colour2', 'tenant_name', 'domain','company_name','company_phone','address1','support_email','API_access')->where('domain', $domain)->first();
        }
        else {
            $branding = collect([
                'logo' => null, 'login' => null, 'register' => null, 'colour1' => null, 'colour2' => null, 'domain' => null,'company_name'=>null,'address1'=>null,'company_phone'=>null,'support_email'=>null, 'tenant_name' => 'Imported','API_access'=>0
            ]);
        }
        View::share('branding', $branding);
        $host = \request()->getHost();


        if (Str::contains($host, 'moloffical.club')) {
            config(['app.name' => 'Moloffical']);
            config(['app.url' => 'https://moloffical.club']);
            config(['app.main_url' => 'https://moloffical.club']);
            config(['app.domain' => 'moloffical.club']);
            config(['app.asset_url' => 'https://moloffical.club/']);
            config(['short-url.asset_url' => 'https://moloffical.club/']);
            $prefix = str_replace(['.', '-'], '', $domain);
            View::share('isTLD', true);
            View::share('prefix', $prefix);
            Session::put('domain', $domain);
            Session::put('branding', $branding);
        }

        elseif  (Str::contains($host,'textmanagementportal.co.uk')) {

            config(['app.name' => 'Text Management Portal']);
            config(['app.url' => 'https://textmanagementportal.co.uk']);
            config(['app.main_url' => 'https://textmanagementportal.co.uk']);
            config(['app.domain' => 'textmanagementportal.co.uk']);
            config(['app.asset_url' => 'https://textmanagementportal.co.uk/']);
            $prefix = str_replace(['.', '-'], '', $domain);
            View::share('isTLD', true);
            View::share('prefix', $prefix);
            Session::put('domain', $domain);
            Session::put('branding', $branding);
        }

        elseif (Str::contains($host,'notext.uk')){

            config(['app.name' => 'notext']);
            config(['app.url' => 'https://notext.uk']);
            config(['app.main_url' => 'https://notext.uk']);
            config(['app.domain' => 'notext.uk']);
            config(['app.asset_url' => 'https://notext.uk/']);
            $prefix = str_replace(['.', '-'], '', $domain);
            View::share('isTLD', true);
            View::share('prefix', $prefix);
            Session::put('domain', $domain);
            Session::put('branding', $branding);


        }
        else{
            // Set other domain-specific configurations}
            // Default to .microsite.website or handle other cases as needed
//            config(['session.domain' => '.microsite.website']);
            View::share('isTLD',false  );
        }
        Session::put('domain', $domain);
        Session::put('branding', $branding);
//        Config::set('session.domain', $domain);
//        Config::set('session.domain', $domain);
        $tenant = Tenant::where('domain', $domain)->first();


        if ($tenant){
            $stripeTenant = StripePerTenant::where('tenant_id', $tenant->id)->first();

            if($stripeTenant){
                Config::set('cashier.key', $stripeTenant->stripe_token_live);
                Config::set('cashier.secret', $stripeTenant->stripe_secret_live);
            } else{
                Config::set('cashier.key', env('STRIPE_KEY'));
                Config::set('cashier.secret', env('STRIPE_SECRET'));
            }

        }else{
            Config::set('cashier.key', env('STRIPE_KEY'));
            Config::set('cashier.secret', env('STRIPE_SECRET'));
        }

        View::share('domain', $domain);
        View::share('branding', $branding);



        Collection::macro('paginate', function($perPage, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage), // $items
                $this->count(),                  // $total
                $perPage,
                $page,
                [                                // $options
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

//
//        Queue::after(function (ContactsToSchedule $event) {
//            $scheduledMessage = DB::table('scheduled_messages')->find($event->scheduleId);
//            $scheduledMessage->update(['status' =>'pending']);
//        });

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
