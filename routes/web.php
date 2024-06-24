<?php

use App\Http\Controllers\CompanyContoller;
use App\Http\Controllers\CompanyManagment;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptoutController;
use App\Http\Controllers\PaymentRecordController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScheduledMessageController;
use App\Http\Controllers\StripePaymentController;
use App\Models\Contact;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\ChinaMobileAPI;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$mainDomains = explode(',',config('app.top_level_domains') ); // Ideally, this should come from a config or .env file





//Route::get('/optout/{id}',[OptoutController::class,'form']);
//Route::post('/optout/{id}',[OptoutController::class,'optOutUpdate'])->name('optout');
//
//Route::get('/optedout/bye',[OptoutController::class,'bye'])->name('bye');


    Route::get('/opt/{id}',[OptoutController::class,'form']);
    Route::post('/opt/{id}',[OptoutController::class,'optOutUpdate'])->name('optout');
    Route::get('/opt/bye',[OptoutController::class,'bye'])->name('bye');



foreach ($mainDomains as $domain) {
    $prefix = str_replace(['.','-'],'',$domain);

    Route::domain($domain)->name($prefix.'.')->group(function () use($domain)
    {

        Route::get('/opt/bye',[OptoutController::class,'bye'])->name('bye');




        Route::get('/', function () {
            return view('auth.login');
        })->name('login');

        Route::get('/register', function () {
            return view('auth.register');
        });


        Route::get('/invite/register/{team}',function ($tenant){
            return view('auth.invite.register');
        })->name('invite.new.user');


        Route::middleware(['auth:web', config('jetstream.auth_session'),
        ])->group(function (){
            Route::get('/choice', [DashboardController::class,'noBusiness'])->name('holding.screen');
            Route::post('/choice', [DashboardController::class,'noBusinessUpdate'])->name('update.choice');


        });


        Route::middleware(['check.user.status',
            'auth:web',
            config('jetstream.auth_session'),
            'verified',
            'domain'
        ])->group(function () use($domain) {




            Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

            Route::get('/contacts', [ContactController::class,'index'])->name('contacts');
            Route::get('/groups', [GroupController::class,'index'])->name('groups');
            Route::get('/message', [MessageController::class,'index'])->name('message');

            Route::get('/message/{slug}/edit', [MessageController::class,'showTld'])->name('message.show');
            Route::get('/message/{slug}/clone', [MessageController::class,'cloneTld'])->name('message.clone');


            Route::get('/message/templates', [MessageController::class,'templates'])->name('message.templates');
            Route::get('/campaigns', [ScheduledMessageController::class,'index'])->name('campaigns');
            Route::get('/campaigns/{id}/show', [ScheduledMessageController::class,'showTld'])->name('campaigns.show');
            Route::get('/credits', [StripePaymentController::class,'index'])->name('credits');
            Route::get('/invoices', [PaymentRecordController::class,'index'])->name('invoices');
            Route::get('/invoice/{PaymentRecord}/download', [PaymentRecordController::class,'showTld'])->name('invoice.download');



            Route::get('/company/branding', [CompanyContoller::class,'index'])->name('company.branding');
            Route::get('/company/details', [CompanyContoller::class,'show'])->name('company.details');
            Route::post('/company/{id}/delete', [CompanyContoller::class,'delete'])->name('company.delete');



            Route::get('/manage/companies', [CompanyManagment::class,'index'])->name('manage.companies')->middleware('portal.user');
            Route::get('/portal/branding', [TenantController::class,'branding'])->name('portal.branding')->middleware('portal.user');

            Route::get('/manage/company/{user:id?}', [CompanyManagment::class,'takeoverCompanyTld'])->name('portal.company.manage')->middleware('portal.user');
            Route::get('/manage/companies/leave', [CompanyManagment::class,'leaveTakeoverCompanyTld'])->name('portal.company.manage.leave');
            Route::get('/download/{path}', [ContactController::class,'downloadTempFile'])->name('download.temp');


//            Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
//
//                if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
//                    Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
//                    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
//                }
//
//                $authMiddleware = config('jetstream.guard')
//                    ? 'auth:'.config('jetstream.guard')
//                    : 'auth';
//
//                $authSessionMiddleware = config('jetstream.auth_session', false)
//                    ? config('jetstream.auth_session')
//                    : null;
//
//                Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
//                    // User & Profile...
//                    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
//
//                    Route::group(['middleware' => 'verified'], function () {
//                        // API...
//                        if (Jetstream::hasApiFeatures()) {
//                            Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
//                        }
//
//                        // Teams...
//                        if (Jetstream::hasTeamFeatures()) {
//                            Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
//                            Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
//                            Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
//
//                            Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
//                                ->middleware(['signed'])
//                                ->name('team-invitations.accept');
//                        }
//                    });
//                });
//            });


        });




    });
}


Route::domain('{domain}.' . env('DOMAIN'))->middleware(['domain','web'])->group(function ($domain) {

Route::get('/send/test',[\App\Http\Controllers\TestController::class,'index']);




Route::get('/', function ($domain) {
    return view('auth.login');
});

    Route::get('/register', function ($domain) {
        return view('auth.register');
    });


Route::get('/invite/register/{team}',function ($domain,$tenant){
    return view('auth.invite.register');
})->name('invite.new.user');


    Route::middleware(['auth:web', config('jetstream.auth_session'),
    ])->group(function (){
        Route::get('/choice', [DashboardController::class,'noBusiness'])->name('holding.screen');
        Route::post('/choice', [DashboardController::class,'noBusinessUpdate'])->name('update.choice');


    });


Route::middleware(['check.user.status',
    'auth:web', config('jetstream.auth_session'), 'verified','domain'
        ])->group(function ()use($domain) {




            Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

            Route::get('/contacts', [ContactController::class,'index'])->name('contacts');
            Route::get('/groups', [GroupController::class,'index'])->name('groups');
            Route::get('/message', [MessageController::class,'index'])->name('message');
            Route::get('/message/{slug}/edit', [MessageController::class,'show'])->name('message.show');
            Route::get('/message/{slug}/clone', [MessageController::class,'clone'])->name('message.clone');


            Route::get('/message/templates', [MessageController::class,'templates'])->name('message.templates');
            Route::get('/campaigns', [ScheduledMessageController::class,'index'])->name('campaigns');
            Route::get('/campaigns/{id}/show', [ScheduledMessageController::class,'show'])->name('campaigns.show');
            Route::get('/credits', [StripePaymentController::class,'index'])->name('credits');
            Route::get('/invoices', [PaymentRecordController::class,'index'])->name('invoices');
            Route::get('/invoice/{PaymentRecord}/download', [PaymentRecordController::class,'show'])->name('invoice.download');



            Route::get('/company/branding', [CompanyContoller::class,'index'])->name('company.branding');
            Route::get('/company/details', [CompanyContoller::class,'show'])->name('company.details');
            Route::post('/company/{id}/delete', [CompanyContoller::class,'delete'])->name('company.delete');



            Route::get('/manage/companies', [CompanyManagment::class,'index'])->name('manage.companies')->middleware('portal.user');
            Route::get('/portal/branding', [TenantController::class,'branding'])->name('portal.branding')->middleware('portal.user');

            Route::get('/manage/company/{user?}', [CompanyManagment::class,'takeoverCompany'])->name('portal.company.manage')->middleware('portal.user');
            Route::get('/manage/companies/leave', [CompanyManagment::class,'leaveTakeoverCompany'])->name('portal.company.manage.leave');
    Route::get('/download/{path}', [ContactController::class,'downloadTempFile'])->name('download.temp');


});

});



Route::domain(env('APP_CENTRAL').'.' . env('DOMAIN'))->group(function () {

    Route::get('/tenant/management', [TenantController::class, 'index'])->name('portal.management')->middleware('global.user');
});
