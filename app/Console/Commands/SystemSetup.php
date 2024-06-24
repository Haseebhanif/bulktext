<?php

namespace App\Console\Commands;

use App\Mail\Welcome;
use App\Models\Company;
use App\Models\Group;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SystemSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbfb:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up portal from a fresh deployment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createTenant();
        return Command::SUCCESS;
    }

    private function createTenant(){
        return DB::transaction(function () {
          return tap(Tenant::create([
                'tenant_name' => 'app',
                'domain' => 'app',
                'status' => 'active'

            ]), function (Tenant $tenant) {
              $tenant->save();
              $this->createGlobalAdmin();
            });
        });


    }



    private function createGlobalAdmin(){

        return DB::transaction(function () {

            return tap(User::create([
                'name' => 'Super User',
                'email' => 'superuser@superuser.com',
                'password' => Hash::make('superuser@superuser.com'),
                'email_verified_at'=>Carbon::now()->toDateString(),
                'is_portal' => 1,
                'is_global' => 1,


            ]), function (User $user) {
                   $company = $this->createCompany($user);
                    $this->createTeam($user,$company);
                    $user->current_company_id = $company->id;
                    $user->save();
            });
        });
    }


    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user,Company $company)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]." Group",
            'personal_team' => true,
            'company_id'=>$company->id
        ]));
        $this->createGroups($user);
    }

    /**
     * Create an All Contacts Group for the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createGroups(User $user)
    {

        Group::create([
            'name' => ucfirst('Group'),
            'team_id' => $user->currentTeam->id
        ]);
    }


    /**
     * Create an overall company for the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createCompany(User $user)
    {


        $tenantquery = Tenant::query();
        $domain =  'app';
        $tenant = $tenantquery->where('domain',$domain)->firstOrFail();

        $user->update(['tenant_id'=>$tenant->id]);

        return Company::create([
            'company_name'=>'DBFB Communications',
            'creator_id'=>$user->id,
            'tenant_id'=>$tenant->id
        ]);
    }
}
