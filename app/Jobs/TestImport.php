<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestImport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

   public $teamId;
    public $importGroup;
    public $location;
    public $userId;
    public  $email;
    public $branding;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($teamId, $importGroup, $location, $userId, $email, $branding)
    {
        $this->teamId = $teamId;
        $this->importGroup = $importGroup;
        $this->location = $location;
        $this->userId = $userId;
        $this->email = $email;
        $this->branding = $branding;

        $this->onQueue('import');
        $this->delay(1);
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info("Test data $this->teamId  -  $this->importGroup - $this->location - $this->userId - $this->email - $this->branding");
    }
}
