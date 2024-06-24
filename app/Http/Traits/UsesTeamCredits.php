<?php


namespace App\Http\Traits;

use App\Models\Team;
use App\Models\TeamCredit;
use App\Models\TeamCredit as Credit;
use Illuminate\Support\Facades\Auth;

trait UsesTeamCredits
{

    /**
     * Get the credit amount for specified team
     * @return mixed
     */
    public function balance(Team $team)
    {
        return ['team'=>$team->name,'amount'=>$team->credits->amount];
    }



    /**
     * Handles updating the team's credits
     *
     * @param $amount
     * @return mixed
     */
    public function updateCredits($amount)
    {
        $credits = Credit::where('team_id', '=', \request()->user()->currentTeam->id)->first();
        $credits->amount = $amount;
        $credits->save();

        return $credits;
    }

    /**
     * Handles adding more credits to the team's existing
     * amount of credits.
     *
     * @param $amount
     * @return mixed
     */
    public function addCredits($amount)
    {

        $credits = Credit::where('team_id', '=', \request()->user()->currentTeam->id)->first();
        $credits->amount = $credits->amount + $amount;
        $credits->save();

        return $credits;
    }


    /**
     * Handles deducting credits from the team's existing
     * amount of credits
     *
     * @param $amount
     * @return mixed
     */
    public function deductCredits($amount)
    {
        $id = \request()->user()->currentTeam->id;
        $credits = Credit::where('team_id', '=', $id)->first();
        $credits->amount = $credits->amount - $amount;
        $credits->save();

        return $credits;
    }

}
