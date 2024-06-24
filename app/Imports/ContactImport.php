<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\CustomContactInfo;
use App\Notifications\ImportHasFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class ContactImport implements WithValidation,OnEachRow,ShouldQueue,WithChunkReading, WithHeadingRow, WithBatchInserts,WithUpserts,SkipsOnFailure{
    /**
    * @param array $row
    *
    */
    use Importable;

    use SkipsFailures;
    use RemembersRowNumber;

    public $rows = 0;
    public $countImports = 0;
    public $countFailures = 0;
    public $countFailuresRowErrors = [];
    public $group_id;
    public $importedBy;
    public $location;

    public function  __construct($group_id,$location)
    {
        $this->location = $location;
        $this->group_id= $group_id;
        $this->importedBy = Auth::user();
    }

    public function onRow(Row $row)
    {
        $this->rows = $row->getIndex();
        $row      = $row->toArray();

        $this->countImports++;

        $contact =  Contact::updateOrcreate(
            [
                'team_id'    => Auth::user()->currentTeam->id,
                'number'    =>(int) $row['phone_number'],
            ],
            [
            'country_code'    => $row['country_code'],
            'active'    => true,
            'created_by'=>Auth::user()->id
        ]);


        ContactGroup::updateOrcreate([
            'contact_id' => $contact->id,
            'group_id' => $this->group_id,
        ],
            [
                'contact_id' => $contact->id,
                'group_id' => $this->group_id,
            ]);

        //search for custom_

        foreach ($row as $key=>$value){
            if (str_contains($key, 'custom_') && $value) {

                $contact->custom()->create([
                    'custom_name'=>$key,
                    'custom_value'=>$value,
                    'team_id'=> Auth::user()->currentTeam->id
                ]);
            }
        }

        //

    }

    public function rules(): array
    {
        return [
            'phone_number' =>['required', 'min:7', 'max:15', 'digits_between:0,9999999999'],
            'country_code' =>['required', 'min:2', 'max:5', 'digits_between:0,999'],

        ];
    }


    public function getRowCount(): int
    {
        return $this->countImports;
    }

    public function getRowCountFailures(): int
    {
        return $this->countFailures;
    }

    public function getRowErrors(): array
    {
        return $this->countFailuresRowErrors;
    }


    public function batchSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'number';
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                $this->importedBy->notify(new ImportHasFailedNotification());
            },
        ];
    }

}
