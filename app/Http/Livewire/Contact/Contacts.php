<?php

namespace App\Http\Livewire\Contact;

use App\Http\Traits\DataPoints;
use App\Imports\ContactImport;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\CustomContactInfo;
use App\Models\CustomView;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;


class Contacts extends Component
{
    use WithPagination;
    use LivewireAlert;
    use DataPoints;

    protected $listeners = ['groupClick' => 'updateSelectedGroup','confirmedRemove'=>'confirmedRemove','cancelled'=>'cancelled','stats'=>'$refresh','refresh'=>'$refresh','removeFromGroup'=>'removeFromGroup'];

    public $groupSelected;
    public $customSelected =[];


    public $viewingCurrentContacts;
    public $perPage = 25;
    public $orderBy = 'id';
    public $ascDesc = 'DESC';
    public $search;
    public $rowShow = 0;

    public $header = true;
    /**
     * New Group name
     * @var
     */
    public $createNewGroup;

    /**
     * Collects new group name from UI for submit function
     * @var
     */
    public $newGroupName;
    public $nameGroup;

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



    /**
     * selected contacts
     * @var
     */
    public $all = false;
    public $selected = [];
    public $moveGroupSelected;
    public $optedOutFilter = false;

    /**
     * New/Edit Contact
     * @var
     */

    public $contact = [
        'id' => null,
        'country_code' => 44,
        'number' => null,
        'active' => true,
        'custom'=>[],
        'groups'=>[],
        'optout_reason'=>null
    ];
    public $edit = false;

   public  $inTheseGroups = [] ;

    public $groupIn =[];

    public $draw = false;


    public function getQueryString()
    {
        return [];
    }

    public function render()
    {
        //custom cols view per user
        $custom  = CustomView::where('team_id',Auth::user()->currentTeam->id)->get('custom_name')->toArray();
        $this->customSelected  = Arr::flatten($custom);
        $contacts= Contact::Query();

        if (!$this->search) {
//            $contacts = Contact::with(['createdByUser','groups'])->select(DB::raw('DISTINCT ON (contacts.id) contacts.id'),'contacts.*','custom_contact_infos.custom_name','custom_contact_infos.custom_value')
//              ->join('custom_contact_infos','custom_contact_infos.contactable_id','=','contacts.id','left')
//               ->join('group_contacts','group_contacts.contact_id','=','contacts.id','left')
//                ->orderBy('contacts'.$this->orderBy, $this->ascDesc);

            $contacts->with(['createdByUser', 'groups'])
                ->select('contacts.id', 'contacts.*', 'custom_contact_infos.custom_name', 'custom_contact_infos.custom_value')
                ->distinct('contacts.id')
                ->join('custom_contact_infos', 'custom_contact_infos.contactable_id', '=', 'contacts.id', 'left')
                ->leftJoin('group_contacts', 'group_contacts.contact_id', '=', 'contacts.id')
                ->where(function ($query) {
                    $query->whereIn('custom_contact_infos.custom_name', $this->customSelected)
                        ->orWhere('contacts.number', '!=', null);
                })
                ->where('contacts.active', !$this->optedOutFilter)
                ->orderBy('contacts.id', $this->ascDesc)
                ->orderBy($this->orderBy, $this->ascDesc);
        } else {


            $contacts->with(['createdByUser', 'groups'])
                ->select('contacts.id', 'contacts.*', 'custom_contact_infos.custom_name', 'custom_contact_infos.custom_value')
                ->distinct('contacts.id')
                ->join('custom_contact_infos', 'custom_contact_infos.contactable_id', '=', 'contacts.id', 'left')
                ->leftJoin('group_contacts', 'group_contacts.contact_id', '=', 'contacts.id')
                ->where(function ($query) {
                    $query->whereIn('custom_contact_infos.custom_name', $this->customSelected)
                        ->orWhere('contacts.number', '!=', null);
                })
                ->where('contacts.active', !$this->optedOutFilter)
                ->orderBy('contacts.id', $this->ascDesc)
                ->orderBy($this->orderBy, $this->ascDesc)
                ->where('number', 'like', '%' . $this->search . '%')
                ->orWhere('optout_reason', 'ilike', '%' . $this->search . '%');
            //  $contacts->orWhere('groups.name', 'ilike', '%'.$this->search.'%');

            //custom contact search
            if(count($this->customSelected) > 0){
                $contacts->orWhere('custom_value', 'like', '%'.$this->search.'%');
            }
        }



        if($this->groupSelected ){
            $contacts->where('group_contacts.group_id','=', $this->groupSelected);
        }

//        if ($this->optedOutFilter) {
//
//            $contacts->where('active',false);
//        }



        $data = $contacts->paginate($this->perPage);

        $this->viewingCurrentContacts = $data->toArray();


       $customCols = CustomContactInfo::get();
       $custom = $customCols->groupBy('custom_name');



        $this->checkSelectAll();

        return view('livewire.contact.contacts', [
            'contacts' => $data,
            'optouts'=>$this->contactOptOuts()['count'],
            'groups' => Group::get(),
            'custom_cols'=>$custom->all()
        ]);
    }

    public function activate($id)
    {
        if ($id !== $this->rowShow) {
            $this->rowShow = $id;
        } else {
            $this->rowShow = null;
        }
    }

    public function checkSelectAll(){


        if(count($this->selected) == 0 ){
            $this->all = false;
        }
    }

    public function reorder($order)
    {
        $this->orderBy = $order;
        $this->ascDesc = $this->ascDesc == 'DESC' ? 'ASC' : 'DESC';
    }

    /**
     * Selected Contact from list
     * @param  \App\Models\Contact  $contact
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

    /**
     * Group creation from contacts
     */
    public function createNewGroup()
    {
        $this->createNewGroup = !$this->createNewGroup;
    }

    /**
     *Creates a new Contact Group
     */
    public function submitNewGroup()
    {

        $this->validate();
        if ($this->createNewGroup) {
            $group = Group::create([
                'name' => ucfirst($this->nameGroup),
                'team_id' => Auth::user()->currentTeam->id
            ]);
            $this->moveGroupSelected = $group->id;
            $this->createNewGroup = false;
            $this->emit('stats');
        }
    }

    public function moveGroupSubmit()
    {

        if ($this->moveGroupSelected && count($this->selected) > 0 && $this->moveGroupSelected > 0 ) {
            foreach ($this->selected as $contactId) {
                $group = ContactGroup::updateOrCreate(
                    ['group_id' => $this->moveGroupSelected, 'contact_id' => $contactId],
                    ['group_id' => $this->moveGroupSelected, 'contact_id' => $contactId]
                );
            }
            $this->selected =[];
//            $this->emit('notice', ['message'=>'Contacts saved to group','type'=>"Success"]);
         $this->emit('stats');

            $this->alert('success', 'selected contacts moved to group');
        }else{
            $this->alert('info', 'Not processed please select a group');
        }
    }

    public function updateSelectedGroup($data)
    {

        $this->groupSelected = $data;
    }


    public function clearContact(){

       $this->contact = [
            'id' => null,
            'country_code' => 44,
            'number' => null,
            'active' => true,
            'custom'=>[],
            'groups'=>[],
           'optout_reason'=>null
        ];

    }



    public function editContact($id)
    {

        $this->contact = [];
        $data = Contact::with(['custom','groups'])->find($id);

        $this->inTheseGroups  =   ContactGroup::select('groups.name','group_contacts.*')
            ->where('group_contacts.contact_id',$id)
            ->join('groups','group_contacts.group_id','=','groups.id')
            ->get()
            ->toArray();


        $this->contact = [
            'id' => $id,
            'country_code' => $data->country_code,
            'number' => str_replace('-', '', $data->number),
            'active' => $data->active,
            'groups'=>$data->groups,
            'custom'=>$data->custom->toArray(),
            'optout_reason'=>$data->optout_reason,
        ];




        $this->edit = true;
        $this->draw = true;



    }

    public function contactUpdate()
    {


        $this->validate([
            'contact.number' => 'required|numeric|min:3',
            'contact.country_code' => 'required',
            'contact.active' => 'required',
        ]);






        if (array_key_exists('id',$this->contact) && $this->contact['id'] !== null) {

            Contact::where('id',$this->contact['id'])->update(
                [
//                    'number' => $this->contact['number'],
                    'active' => $this->contact['active'],
                    'country_code' => $this->contact['country_code'],
                    'created_by' => Auth::user()->id,
                    'team_id' => Auth::user()->currentTeam->id,
                   // 'company_id' => Auth::user()->currentTeam->company->id

                ]);
            $this->alert('success', 'Contact details updated');
        }else{

            $count = Contact::where('number', $this->contact['number'])->where('team_id', Auth::user()->currentTeam->id,)->get();

            if($count->count() > 0){
                $this->alert('warning', ' Contact number already exits');
                return ;
            }

            Contact::create(
                [
                    'number' => $this->contact['number'],
                    'active' => $this->contact['active'],
                    'country_code' => $this->contact['country_code'],
                    'created_by' => Auth::user()->id,
                    'team_id' => Auth::user()->currentTeam->id,
                  //  'company_id' => Auth::user()->currentTeam->company->id

                ]);

            $this->alert('success', 'Contact details saved');
        }


        $this->contact = [
            'id' => null,
            'country_code' => 44,
            'number' => null,
            'active' => true,
            'custom'=>[]
        ];
        $this->edit = false;

        $this->emit('stats');
    }

    public function removeContacts()
    {
        $this->alert('question', 'Confirm the removal of '.count($this->selected).' contacts', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Submit',
            'onConfirmed' => 'confirmedRemove',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onDismissed' => 'cancelled',
            'timer'=>null
        ]);
    }

    public function confirmedRemove(){


        $i = 0;
        foreach ($this->selected as $key){
            $i++;

            Contact::find($key)->delete();
        }
        $this->selected  = [];
        $this->emit('stats');
        $this->alert('success', $i.' Contacts removed');

    }

    public function denied()
    {
        // Do something when denied button is clicked
    }

    public function cancelled()
    {
        // Do something when cancel button is clicked
        $this->alert('info', 'Removal of contacts cancelled');
    }

    public function updateCustomView($colClicked){

        $customView = new CustomView();
        $user = Auth::user();

       $count = $customView->where('custom_name',$colClicked)->count();
       if($count > 0){
           $customView->where('custom_name',$colClicked)->delete();
       }else{

           $customView->custom_name = $colClicked;
           $customView->user_id = $user->id;
           $customView->team_id = $user->currentTeam->id;
           $customView->save();
       }



        $this->alert('success', ' Contact view updated');
    }

    public function removeSingleContact($contactId){
        $this->selected = [$contactId];
        $this->removeContacts();
    }


    public function confirmRemoval($groupIdRef,$contactIdRef){
        $this->alert('question','Confirm removal from group?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Proceed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onDismissed' => 'cancelled',
            'timer'=>null,

            'inputAttributes' => [
                'groupId' => $groupIdRef,
                 'contactId' => $contactIdRef
            ],
            'onConfirmed' => 'removeFromGroup'
        ]);
        $this->edit = false;
    }

    public function removeFromGroup($response)
    {

        ContactGroup::where('group_id', $response['data']['inputAttributes']['groupId'])->where('contact_id', $response['data']['inputAttributes']['contactId'])->delete();
        $this->alert('success','group removed');
         $this->emit('stats');
    }

    public function newcontact(){
        $this->edit = false;
        $this->contact = [
            'id' => null,
            'country_code' => 44,
            'number' => null,
            'active' => true,
            'custom'=>[],
            'groups'=>[]
        ];
    }



    public function export(){

            return (new \App\Exports\Contacts(
                $this->search,
                $this->groupSelected,
                $this->orderBy,
                $this->ascDesc,
                $this->optedOutFilter
            ))->download('contacts.'.Carbon::now()->format('d-m-Y H-i-s').'.xlsx');
    }
}
