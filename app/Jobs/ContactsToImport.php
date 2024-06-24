<?php

namespace App\Jobs;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Imports\ContactImport;
use App\Imports\ContactsImportNew;
use App\Models\EmailService;
use App\Models\ImportReview;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ContactsToImport implements ShouldQueue
{
    use Dispatchable;
    use EmailConfigSettingTrait;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    public $loadcount  =0;
    public $importCount = 0;

    public $email;
    public $groupId;
    public $fileLoc;
    public $userId;
    public $team;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($team, $groupId, $fileLoc,$user,$email)
    {
        $this->onQueue('import');
        $this->email = $email;

        $this->userId = $user;
        $this->team = $team;
        $this->groupId = $groupId;
        $this->fileLoc = $fileLoc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(" user ID: {$this->userId}");
        Log::info(" TEAM ID: {$this->team}");
        Log::info("LOC: ".public_path()."/uploads");
        Log::info("LOC FILE: ".public_path()."$this->fileLoc");
        if (!User::find($this->userId)) {
            Log::error("Invalid user ID: $this->userId");
            return;
        }
      $user = Auth::loginUsingId($this->userId);
            Log::info('GOT HERE');


         $tenant = EmailService::where('tenant_id',$user->tenant_id)->first();

         if($tenant){
             Config::set('mail.default', 'smtp');
             Config::set('mail.mailers.smtp.host', $tenant->smtp);
             Config::set('mail.mailers.smtp.port', $tenant->port);
             Config::set('mail.mailers.smtp.encryption', $tenant->encryption);
             Config::set('mail.mailers.smtp.username', $tenant->username);
             Config::set('mail.mailers.smtp.password', decrypt($tenant->password));
             Config::set('mail.from.address', $tenant->email);
             Config::set('mail.from.name', $tenant->name);

             config('mail.default', 'smtp');
             config('mail.mailers.smtp.host', $tenant->smtp);
             config('mail.mailers.smtp.port', $tenant->port);
             config('mail.mailers.smtp.encryption', $tenant->encryption);
             config('mail.mailers.smtp.username', $tenant->username);
             config('mail.mailers.smtp.password', decrypt($tenant->password));
             config('mail.from.address', $tenant->email);
             config('mail.from.name', $tenant->name);
             Log::info("CONFIG MAIL FROM JOB ".json_encode(config('mail.mailers')));
         }

       $tenantName =  Tenant::findOrFail($user->tenant_id);

        Excel::import(new ContactsImportNew($this->team, $this->groupId, $this->fileLoc, $this->userId,$this->email,$tenantName->tenant_name), public_path().'/uploads/'.$this->fileLoc);
    }

}
