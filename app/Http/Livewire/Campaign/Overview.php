<?php

namespace App\Http\Livewire\Campaign;

use App\Exports\CampainExport;
use App\Exports\CreditPaymentExport;
use App\Exports\SentSMSExport;
use App\Http\Traits\DataPoints;
use App\Imports\ContactImport;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\CustomContactInfo;
use App\Models\CustomView;
use App\Models\Group;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class Overview extends Component
{
    use WithPagination;
    use LivewireAlert;
    use DataPoints;


    public $campaign;
    public $recipients;

    public $scheduledMessage;

    public $perPage = 25;
    public $orderBy = 'id';
    public $ascDesc = 'DESC';
    public $search;
    public $rowShow = 0;

    public $header = true;

    /**
     * Validation for new group creation
     */
    protected $rules = [
        'nameGroup' => 'required|min:3'
    ];

    /**
     * contants Data points
     * @var
     */


    public function getQueryString()
    {
        return [];
    }

    public function render()
    {
        $this->campaign = ScheduledMessage::findOrFail($this->scheduledMessage);


        $contacts = ScheduledMessageContacts::where('scheduled_message_id', $this->scheduledMessage);


        if (!$this->search) {
            $recips = $contacts->orderBy($this->orderBy, $this->ascDesc);

        } else {
            $recips = $contacts->where(function ($query) {

                //custom contact search
                //main contact search
                return $query->orWhere('number', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('SMS_UID', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('sent', 'LIKE', '%' . $this->search . '%');
            })
                ->orderBy($this->orderBy, $this->ascDesc);
        }

//        if ($this->groupSelected) {
//            $contacts->whereHas('groups',function ($query){
//              return  $query->whereIn('groups.id', $this->groupSelected);
//            });
//        }
        $data = $recips->paginate($this->perPage);


        return view('livewire.campaign.overview', [
            'contacts' => $data,
            'sent' => ScheduledMessageContacts::where('scheduled_message_id', $this->scheduledMessage)->whereNotNull('RESULT_DESC')->count(),
            'pending' => ScheduledMessageContacts::where('scheduled_message_id', $this->scheduledMessage)->whereNull('RESULT_DESC')->count(),
            'delivered' => ScheduledMessageContacts::where('scheduled_message_id', $this->scheduledMessage)->whereNotNull('dr_response')->count(),
        ]);
    }

    public function exportDate(){

        return Excel::download(new CampainExport($this->scheduledMessage), $this->campaign->name.'-'.Carbon::now().'.xlsx');

    }

    public function checkSelectAll()
    {


        if (count($this->selected) == 0) {
            $this->all = false;
            $this->emit('stats');
        }
    }

    public function reorder($order)
    {
        $this->orderBy = $order;
        $this->ascDesc = $this->ascDesc == 'DESC' ? 'ASC' : 'DESC';
    }

    /**
     * Selected Contact from list
     * @param \App\Models\Contact $contact
     */
    public function selectAll()
    {
        $this->all = !$this->all;

        if ($this->all == true) {
            $this->selected = array_column($this->viewingCurrentContacts['data'], 'id');
        } else {
            $this->selected = $this->selected = [];
        }
    }

}


