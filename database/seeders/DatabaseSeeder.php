<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Group;
use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Database\Factories\GroupFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->createTenant();



        $superUserEmail = 'superuser@superuser.com';

        if(User::where('email',$superUserEmail)->count() < 1){
            DB::transaction(function () use ($superUserEmail){
                return tap(User::create(
                    [
                    'name' => 'Super User',
                    'email' => $superUserEmail,
                    'password' => Hash::make($superUserEmail),
                     ]
                ), function (User $user) {
                    $this->createSuperUserTeam($user);
                }
                );
            });

        }

        DB::transaction(function () {
            return tap(User::create(
                [
                    'name' => 'Test User',
                    'email' => 'test@test.com',
                    'password' => Hash::make('test@test.com'),
                ]
            ), function (User $user) {
                $this->createTeam($user);
            }
            );
        });

       Contact::factory(30)->create();
       Group::factory(7)->create();

    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createSuperUserTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' =>'Global Admin',
            'personal_team' => false,

        ]));
    }

    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' =>'Test Dept',
            'personal_team' => true,
        ]));
    }

    protected function createTenant(){


        Tenant::create([

            'tenant_name'=>'sms',
            'domain'=>"sms.".env('DOMAIN'),
            'status'=>'active'

        ]);


    }
}
