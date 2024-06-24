<?php

namespace App\Http\Livewire\Group;

use App\Models\ContactGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use \Jantinnerezo\LivewireAlert\LivewireAlert;

class Groups extends Component
{
    protected $listeners = ['groupClick'=>'setGroup','stats'=>'$refresh','confirmedRemoval'=>'remove'];
    use LivewireAlert;

    public $notable = false;
    public $scheduling = false;

    public $classes = 'sm:grid-cols-1 md:grid-cols-6 gap-4';
    public $groups;
    public $search;
    public $groupsContent;
    public $activeGroupId;
    public $activeGroupName;

    public $newGroupName;

    public function render()
    {


        if(!$this->search){
            $groups = Group::get();
        }else{
            $groups = Group::with('contacts')->where(function ($query){
                return  $query->orWhere('name', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('created_at', 'LIKE', '%'.$this->search.'%');
            })->get();
        }



        $this->groups = $groups->groupBy(function($person,$key) {
             return $person->name[0];     //treats the name string as an array
            })
            ->sortBy(function($item,$key){      //sorts A-Z at the top level
                return $key;
            })->all();

        return view('livewire.group.groups');
    }




    public function saveNewGroup(Request $request){

        $validatedData = $this->validate([
            'newGroupName' => 'required|min:3|unique:groups,name',
        ]);



        $group = Group::create([
            'name'=> ucfirst($this->newGroupName),
            'team_id'=>Auth::user()->currentTeam->id
        ]);

        $this->alert('success', 'New Group Added');
        $this->emit('refresh');
    }


    public function setGroup($id){
        $this->activeGroupId = $id;
    }


    public function deleteGroup($id){

        $this->alert('question','Confirm deletion of group', [
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

    public function remove($data){

        $id =   $data['data']['inputAttributes']['id'];
       try{
           ContactGroup::where('group_id',$id)->delete();
           Group::findOrFail($id)->delete();
           $this->alert('success','Group Removed');
       }catch (\Throwable $throwable){
           $this->alert('error','Error Removing Group');
       }
    }



}
