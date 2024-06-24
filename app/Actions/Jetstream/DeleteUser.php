<?php

namespace App\Actions\Jetstream;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     *
     * @param  \Laravel\Jetstream\Contracts\DeletesTeams  $deletesTeams
     * @return void
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     *
     */
    public function delete($user)
    {
       $company =  Company::query();
       $result = $company->where('creator_id',$user->id)->count();

       if($result == 0){
           DB::transaction(function () use ($user) {
               $this->deleteTeams($user);
               $user->deleteProfilePhoto();
               $user->tokens->each->delete();
               $user->delete();
           });
       }else{
           \request()->session()->flash('flash.banner', 'Please contact bulk text services to remove your account!');
           \request()->session()->flash('flash.bannerStyle', 'danger');
           return redirect('/dashboard');
       }
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function deleteTeams($user)
    {
        $user->teams()->detach();
        $user->ownedTeams->each(function ($team) {
            $this->deletesTeams->delete($team);
        });
    }
}
