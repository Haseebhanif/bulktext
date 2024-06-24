<?php

namespace App\Exports;

use App\Models\ScheduledMessageContactsCommandModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampainExport  implements FromCollection,WithHeadings
{

    public $id;



    public function __construct($id)
    {
        $this->id = $id;
    }

    public function headings(): array
    {

        //return Schema::getColumnListing('scheduled_message_contacts');

        return [
            'SEND DATE',
            'SEND TIME',
            'SENDER NAME',
            'MESSAGE',
            'SMS_UID',


            'CHARACTER COUNT',
            'RATE',
            'CREDITS USED',

            'COUNTRY',
            'NUMBER',

            'DEPT',
            'COMPANY',
            'CREATED',
            'UPDATED',

            'RESULT_CODE',
            'RESULT_DESC',
            'SENT',

            'dr_type',
            'dr_response',
        ];

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ScheduledMessageContactsCommandModel::select(
            'scheduled_messages.send_date',
            'scheduled_messages.send_time',
            'scheduled_message_contacts.sender_id AS sender',
            'message_sent AS message',
            'scheduled_message_contacts.SMS_UID',

            'sms_qty',
            'sms_rate',
            'credits_used',

            'country_code',
            'number',

            'teams.name AS team',
            'companies.company_name AS company',

            'scheduled_message_contacts.created_at',
            'scheduled_message_contacts.updated_at',


            'RESULT_CODE',
            'RESULT_DESC',
            'sent',

            'dr_type',
            'dr_response',

        )
            ->where('scheduled_message_id',$this->id)
            ->join('scheduled_messages','scheduled_messages.id','=','scheduled_message_contacts.scheduled_message_id')
            ->join('teams','teams.id','=','scheduled_message_contacts.team_id')
            ->join('companies','companies.id','=','scheduled_message_contacts.company_id')
            ->get();
    }

}
