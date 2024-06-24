<?php

namespace App\Exports;

use App\Models\ScheduledMessageContactsCommandModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SentSMSExport implements FromCollection,WithHeadings
{

    public $from;
    public $to;

    public function __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;

    }


    public function headings(): array
    {

        //return Schema::getColumnListing('scheduled_message_contacts');

        return [
            'MSG ID',
            'SENDER NAME',
            'MESSAGE',
            'CHARACTER COUNT',
            'RATE',
            'CREDITS USED',
            'COUNTRY',
            'NUMBER',

            'DEPT ID',
            'COMPANY',
            'CREATED',
            'UPDATED',

            'SMS_UID',
            'RESULT_CODE',
            'RESULT_DESC',
            'SENT',
        ];

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $f = Carbon::createFromDate($this->from)->startOfDay();
       $t = Carbon::createFromDate($this->to)->startOfDay();
       return ScheduledMessageContactsCommandModel::select(

            'scheduled_message_id',
            'sender_id',
            'message_sent',
            'sms_qty',
            'sms_rate',
            'credits_used',
            'country_code',
            'number',
            'teams.name',
            'companies.company_name',

            'scheduled_message_contacts.created_at',
            'scheduled_message_contacts.updated_at',

            'SMS_UID',
            'RESULT_CODE',
            'RESULT_DESC',
            'sent',

        )
            ->join('teams','teams.id','=','scheduled_message_contacts.team_id')
            ->join('companies','companies.id','=','scheduled_message_contacts.company_id')
            ->whereBetween('scheduled_message_contacts.created_at', [$f, $t])->get();
    }
}
