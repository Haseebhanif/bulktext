<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });


        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', $request->email)->first();
            $url = request()->getHost();
            $parts = explode('.', $url);
            $subdomain = count($parts) > 2 ? $parts[0] : null;


            if (empty($url) && empty($subdomain)) {
                // Instead of returning a response, you could log this or handle it differently
                throw ValidationException::withMessages([
                    'email' => ['empty.'],
                ]);
                return null;
            }

            $domain = Tenant::query()
                ->when($url, function ($query) use ($url) {
                    return $query->where('domain', $url);
                })
                ->when($subdomain, function ($query) use ($subdomain) {
                    return $query->orWhere('domain', $subdomain);
                })
                ->first();

            if (!$domain || !$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['issue with details.'],
                ]);
                return null;
            }

            if ($user->tenant_id != $domain->id) {
                // Use exception for error handling
                throw ValidationException::withMessages([
                    'email' => ['Account not accessible from here.'],
                ]);
            }

            return $user;
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
