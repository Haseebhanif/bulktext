<?php

namespace App\Http\Livewire\Message\Templates;

use App\Models\MessageTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class TemplateList extends Component
{

    public $search;
    public $selected;
    public $templates = [];
    public $companyTemplates = [];

    protected $listeners = ['userTemplateSaved'=>'loadUserSavedTemplates'];

    public function render()
    {
    $systemTemplates =    trans('templates');
        if($this->search){
            $this->templates =  Arr::where($systemTemplates,function ($value, $key) {
                if(str_contains(strtoupper($key), strtoupper($this->search))){
                    return $value;
                }

            });
        }else{
            $this->templates =   $systemTemplates;
        }


        //$this->templates = trans('templates');
        $this->companyTemplates =  $this->loadUserSavedTemplates();

        return view('livewire.message.templates.template-list');
    }


    public function addTemplate($type,$template){

        if($type == 'template' ){
            $this->templates = trans('templates');
            $this->templates[$template];
            $this->emit('templateSelected', $this->templates[$template]);
        }else{

            $this->emit('templateSelected', [
                'text'=> $this->companyTemplates[$template]['message'],
                'vars'=> json_decode($this->companyTemplates[$template]['variables'],true)['template'],
            ]);
        }
    }

    public function loadUserSavedTemplates(){
        $user = Auth::user();

        if(!$this->search){
            $template = MessageTemplate::where('company_id',$user->currentTeam->company->id)->get();
        }else{
            $template = MessageTemplate::where(function ($query){
                return  $query->orWhere('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('created_at', 'LIKE', '%'.$this->search.'%');
            })->where('company_id',$user->currentTeam->company->id)->get();
        }

        return $template;
    }
}
