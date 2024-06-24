<?php

namespace App\Imports;

use App\Mail\ImportProcessed;
use App\Models\ContactGroup;
use App\Models\ContactJobs;
use App\Models\ImportReview;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Row;


class ContactsImportNew  implements  OnEachRow, WithHeadingRow, SkipsOnFailure, WithEvents, WithValidation,WithBatchInserts, WithChunkReading
{
    use SkipsFailures;

    private $successCount = 0;
    private $errorCount = 0;


    public $teamId;
    public $userId;
    public $groupId;
    public $email;
    public $branding;
    public $fileLoc;
    public $tenantName;



    public function __construct($teamId, $groupId, $fileLoc,$userId,$email,$tenantName)
    {
        $this->fileLoc = $fileLoc;
        $this->groupId = $groupId;
        $this->teamId = $teamId;
        $this->userId = $userId;
        $this->email = $email;
        $this->tenantName = $tenantName;

        $user = User::find($this->userId);
        $this->branding =  Tenant::select('id','logo', 'login', 'register', 'colour1', 'colour2', 'tenant_name', 'domain')->find($user->tenant_id);

    }


    public function onRow(Row $row)
    {


        $user =  Auth::loginUsingId($this->userId);
        if (!$user) {
          Log::error("User not found for ID: {$this->userId}");
            // Handle the error appropriately
            return;
        }

        try {

            $contact =  ContactJobs::updateOrCreate(
                [
                    'team_id'    => $this->teamId,
                    'number'    =>(int) $row['phone_number'],
                ],
                [
                    'team_id'    => $this->teamId,
                    'country_code'    => $row['country_code'],
                    'active'    => true,
                    'created_by'=>$this->userId,
                ]);



            ContactGroup::updateOrCreate([
                'contact_id' => $contact->id,
                'group_id' => $this->groupId,
            ],
                [
                    'contact_id' => $contact->id,
                    'group_id' => $this->groupId,
                ]);

            //search for custom_
            $rowData = $row->toArray();
            foreach ($rowData as $key => $value) {
                if (Str::startsWith(mb_strtolower($key), 'custom_') && $value !== null) {
                    // The header starts with 'custom_', and the cell has a value
                    // Here, implement your logic to handle the custom field
                    // Example: Create/Update a record in a related model
                    $this->handleCustomField($key, $value, $contact);
                }
            }
            // Row processing and model saving logic
            $this->successCount++;
        } catch (\Exception $e) {
            \Log::error("Error in row {$row->getIndex()}: " . $e->getMessage());

            $this->errorCount++;
            // Handle the error, log it, or store it as needed
        }
    }

    private function handleCustomField($key, $value, $contact) {
        // Implement your logic for handling the custom field
        // Example: saving custom fields in a related model
        $contact->custom()->updateOrCreate(
            [
                'custom_name'=>mb_strtolower($key),
                'team_id'=> $this->teamId,
            ],
            [
            'custom_name'=>mb_strtolower($key),
            'custom_value'=>$value,
            'team_id'=> $this->teamId,
        ]);
    }
    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }



    public function rules(): array
    {
        $variable = ['44'];
        return [
            'phone_number' =>['required', 'min:7', 'max:15', 'digits_between:0,9999999999'],
            'country_code' =>['required', 'min:2', 'max:5', 'digits_between:0,5',    Rule::in($variable)],

        ];
    }







    public function uniqueBy()
    {
        return 'phone_number';
    }

    public function chunkSize(): int
    {
        return 5000;
    }
    public function batchSize(): int
    {
        return 10000;
    }




    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                // Update contact_imports table
                $this->updateContactImportTable();
            },
        ];
    }


    private function updateContactImportTable()
    {
        $failures = $this->failures();
        \Log::info('Import Failures: ', $failures->toArray());

        // Assuming you pass the ID or some identifier of the contact_imports record
        $contactImport = ImportReview::where('team_id',$this->teamId)->firstOrNew();
        if ($contactImport) {
            $contactImport->complete = true;
            $contactImport->file_name = $this->fileLoc;
            $contactImport->team_id = $this->teamId;
            $contactImport->success_count = $this->successCount;
            $contactImport->error_count = count($this->failures());

            // Collect errors
            $errors = collect($this->failures())->map(function ($failure) {
                return [
                    'row' => $failure->row(), // Row that went wrong
                    'attribute' => $failure->attribute(), // Either heading key (if using heading row concern) or column index
                    'errors' => $failure->errors(), // Actual error messages from Laravel validator
                    'values' => $failure->values() // The values of the row that has failed.
                ];
            });

            $contactImport->errors = $errors->isEmpty() ? null : $errors->toJson();

            $contactImport->save();

            $user =  Auth::loginUsingId($this->userId);

            Log::info("TO: $user->email team id : $this->teamId email : $this->email branding via tenant id : $this->branding TENANT $this->tenantName ");




            Mail::to($user->email)->send(new ImportProcessed($this->teamId,$this->email,$user->tenant_id,$this->tenantName,$this->branding));


        }
    }

}
