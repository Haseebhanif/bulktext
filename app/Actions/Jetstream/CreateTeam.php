<?php

namespace App\Actions\Jetstream;

use App\Models\Company;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);
        $company = $user->current_company_id;

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
            'company_id'=>$company
        ]));
        $this->createGroups($user,$company);
        $this->assignCompanyOwner($user,$company);
        return $team;
    }

    /**
     * Create an All Contacts Group for the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createGroups(User $user,$company)
    {

        Group::create([
            'name' => ucfirst('Group'),
            'team_id' => $user->currentTeam->id
        ]);
    }

    /**
     * Assigns company creator to all the teams created.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function assignCompanyOwner(User $user,$company)
    {

        $company =  Company::findOrFail($company);
        DB::table('team_user')->updateOrInsert(
            [
                'team_id'=>$user->currentTeam->id,
                'user_id'=>$company->creator_id,
            ],
            [
                'role'=>'admin',
                'created_at'=>(string) Carbon::now(),
                'updated_at'=>(string) Carbon::now(),
                'isManaged'=>false
            ]);


    }
}
