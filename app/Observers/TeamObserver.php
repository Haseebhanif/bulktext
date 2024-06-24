<?php

namespace App\Observers;


use App\Models\Team;
use App\Models\TeamCredit as Credit;

class TeamObserver
{
    /**
     * Handle the Team "created" event.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function created(Team $team)
    {
        $credits = new Credit();
        $credits->team_id = $team->id;
        $credits->company_id = $team->company->id;
        $credits->save();
    }
}
