<?php

namespace App\Exports;

use App\Models\PaymentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CreditPaymentExport implements FromCollection,WithHeadings,WithMapping
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
            'ID',
            'STRIPE REF',
            'CREDITS',
            'PAYMENT',
            'CURRENCY',
            'CUSTOMER',
            'DEPT',
            'COMPANY',
            'TENANT',
            'STATUS',
            'DATE'
        ];

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $f = Carbon::createFromDate($this->from)->startOfDay();
        $t = Carbon::createFromDate($this->to)->startOfDay();

        return DB::table('payment_records')
            ->select(

                'payment_records.id',
                    'payment_ref',
                    'credits',
                    'amount',
                    'currency',
                    'users.name',
                    'teams.name AS team_name',
                    'tenants.tenant_name AS tenant_name',
                    'companies.company_name',
                    'payment_records.status',
                    'payment_records.created_at')
            ->join('users','payment_records.customer_id','=','users.stripe_id','left')
            ->join('teams','teams.id','=','payment_records.team_id','left')
            ->join('companies','companies.id','=','payment_records.company_id','left')
            ->join('tenants','companies.tenant_id','=','tenants.id','left')
            ->whereBetween('payment_records.created_at', [$f, $t])->get();
    }

    public function map($payment): array
    {

        return [
            $payment->id,
            $payment->payment_ref,
            $payment->credits,
            $payment->amount/100,
            $payment->currency,
            $payment->name,
            $payment->team_name,
            $payment->company_name,
            $payment->tenant_name,
            $payment->status,
            $payment->created_at,
        ];
    }

}

