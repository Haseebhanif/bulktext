<?php

namespace App\Http\Livewire\Campaign;

use App\Http\Traits\UsesTeamCredits;
use App\Models\ContactGroup;
use App\Models\ScheduledMessage;
use App\Models\ScheduledMessageContacts;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CampaignTable extends Component
{
    use WithPagination;
    use LivewireAlert;
    use UsesTeamCredits;

    public $viewingCurrentContacts;
    public $perPage = 25;
    public $orderBy = 'id';
    public $ascDesc = 'DESC';
    public $search;
    public $rowShow = 0;

    protected $listeners = ['confirmedRemoval'=>'confirmedRemoval'];


    public function render()
    {


        $campaigns = new ScheduledMessage();

        $campaigns->with(['contactsSentTo','contactsDeliveredTo','createdBy','contacts']);
        if(!$this->search){
            $camp = $campaigns->orderBy($this->orderBy,$this->ascDesc);
        }else{
            $camp = $campaigns->where(function ($query){
                return  $query->orWhere('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('send_date', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('status', 'LIKE', '%'.$this->search.'%');
            })->orderBy($this->orderBy,$this->ascDesc);
        }



        $data = $camp->paginate($this->perPage);


        return view('livewire.campaign.campaign-table',[
            'campaigns'=>$data
        ]);
    }


    public function activate($id){


        if($id !== $this->rowShow){
            $this->rowShow  =$id;
        }else{
            $this->rowShow  = null;
        }

    }

    public function removeCampaign($id){

        $this->alert('question','Confirm deletion of campaign', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Proceed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onDismissed' => 'cancelled',
            'timer'=>null,

            'inputAttributes' => [
                'id' => $id,
            ],
            'onConfirmed' => 'confirmedRemoval'
        ]);

    }

    public function confirmedRemoval($data){

        $schedule = ScheduledMessage::where('id', $data['data']['inputAttributes']['id'])->first();

        if($schedule->status == 'pending'){
            $this->addCredits((int)$schedule->total_credits);
        }


        $schedule->delete();
        ScheduledMessageContacts::where('scheduled_message_id', $data['data']['inputAttributes']['id'])->delete();
        $this->alert('success','Deleted campaign');
        $this->emit('creditUpdate');




    }



    public function reorder($order)
    {
        $this->orderBy = $order;
        $this->ascDesc = $this->ascDesc == 'DESC' ? 'ASC' : 'DESC';
    }
}
