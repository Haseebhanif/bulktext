<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Contacts implements FromCollection,WithHeadings
{

    public $search;
    public $groupId;
    public $order;
    public $ascdec;

    public $optedOutFilter;

    public function __construct($search,$groupId,$order,$ascdec,$optedOutFilter)
    {
        $this->search = $search;
        $this->groupId = $groupId;
        $this->order = $order;
        $this->ascdec = $ascdec;
        $this->optedOutFilter = $optedOutFilter;
    }


    use Exportable;

    public function collection(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array
    {
        $contacts = Contact::with(['createdByUser', 'groups'])
            ->select('contacts.id','contacts.country_code', 'contacts.number','contacts.active','contacts.optout_reason', 'contacts.created_at', 'custom_contact_infos.custom_name', 'custom_contact_infos.custom_value')
            ->where('contacts.team_id', Auth::user()->currentTeam->id)
            ->distinct('contacts.id')
            ->leftJoin('custom_contact_infos', 'custom_contact_infos.contactable_id', '=', 'contacts.id')
            ->leftJoin('group_contacts', 'group_contacts.contact_id', '=', 'contacts.id')
            ->orderBy('contacts.id', $this->ascdec)
            ->orderBy($this->order, $this->ascdec);

        if(isset($this->search) && $this->search != null){
             $contacts->where('number', 'like', '%' . $this->search . '%')
            ->orWhere('optout_reason', 'ilike', '%' . $this->search . '%');
        }

        //  $contacts->orWhere('groups.name', 'ilike', '%'.$this->search.'%');


        //    $contacts->where('group_contacts.group_id', $this->groupId);



        if($this->optedOutFilter){
            $contacts->where('active',!$this->optedOutFilter);
        }

        if(isset($this->groupId) && $this->groupId != null){
            $contacts->where('group_contacts.group_id', $this->groupId);
        }

        return   $contacts->get();

    }


    public function headings(): array
    {
        return [
            'id',
            'country_code',
            'contacts',
            'active',
            'optout_reason',
            'created_at',
            'custom_name',
            'custom_value',

        ];
    }
}
