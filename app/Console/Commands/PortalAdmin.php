<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PortalAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $portalManagers = User::where('is_portal',1)->get();
        $teams = DB::table('teams')->get();

        foreach ($portalManagers as $user){

            foreach ($teams as $team) {

                DB::table('team_user')->updateOrInsert(
                    [
                        'team_id'=>$team->id,
                        'user_id'=>$user->id,
                    ],
                    [
                    'role'=>'portal',
                    'created_at'=>(string) Carbon::now(),
                    'updated_at'=>(string) Carbon::now()

                ]);
            }

        }


        return Command::SUCCESS;
    }
}
