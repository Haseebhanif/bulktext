<?php

namespace App\Actions\Fortify;

use App\Mail\NewUserEmail;
use App\Mail\Welcome;
use App\Models\Company;
use App\Models\Group;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {


        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'company' => isset($input['csrf2']) ? '': ['required', 'string', 'max:255','unique:companies,company_name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {

            if(isset($input['csrf2'])) {
               $teamId = \Crypt::decryptString($input['csrf2']);
                $tenant =     Team::find($teamId)->company->tenantParent;

            }else{
                //TM user only registration
                $tenant =   Tenant::where('domain',$input['domain'])->firstOrFail();


            }


            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'tenant_id'=>$tenant->id,
            ]), function (User $user)use($input) {



                if(isset($input['csrf2'])) {

                  $decrypted = Crypt::decryptString($input['csrf2']);

                  $team =  Team::findOrFail($decrypted);

                  $invitations =   TeamInvitation::where('team_id',$team->id)->where('email', $user->email)->firstOrFail();



                    if($team && $invitations){

                        $user->current_team_id = $decrypted;
                        $user->current_company_id =$team->company->id;
                        $user->update();

                        DB::table('team_user')->insert([
                           'team_id'=>$user->currentTeam->id,
                            'user_id'=>$user->id,
                            'role'=>$invitations->role
                        ]);

                    }

                    }
                else
                {
                        $company = $this->createCompany($user,$input);
                        $this->createTeam($user,$company);
                        $this->createGroups($user,$company);
                        $user->current_company_id =$company->id;
                        $user->save();
                 }

                Mail::to($user->email)->send(new Welcome($user->currentTeam->company->tenantParent));
                Mail::to('danielle@dbfb.co.uk')->bcc('robert.schafer@subsidium-ms.com')->send(new NewUserEmail($user));

            });
        });
    }

    /**
     * Create an overall company for the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createCompany(User $user,$input)
    {


         $tenantquery = Tenant::query();
         $domain =  $input['domain'];
         $tenant = $tenantquery->where('domain',$domain)->firstOrFail();
         $user->save();


       return Company::create([
           'company_name'=>$input['company'],
           'creator_id'=>$user->id,
           'tenant_id'=>$tenant->id
        ]);
    }

    /**
     * Create an All Contacts Group for the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createGroups(User $user,$input)
    {

        Group::create([
            'name' => ucfirst('Group'),
            'team_id' => $user->currentTeam->id
        ]);
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
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
            'company_id'=>$company->id
        ]));
    }
}
